// bump cache name to force clients to update when deployed
const CACHE_NAME = 'gold-app-v7';
const APP_SHELL = [
  '/',
  '/manifest.json?v=2',
  '/fonts/vazirmatn.css',
  '/fonts/Vazirmatn-variable.woff2',
  '/vendor/alpinejs.min.js',
  '/icons/icon-192x192.png?v=2',
  '/icons/icon-512x512.png?v=2',
  '/images/logo.png?v=2',
  '/favicon.png?v=2',
  '/favicon.ico?v=2'
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(APP_SHELL))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys()
      .then(keys => Promise.all(keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  const url = new URL(event.request.url);

  if (event.request.method !== 'GET') {
    event.respondWith(fetch(event.request));
    return;
  }

  // هرگز روت‌های ادمین، احراز هویت، جفت‌سازی و API را کش نکن
  if (
    url.pathname.startsWith('/api/') ||
    url.pathname.startsWith('/admin') ||
    url.pathname.includes('/login') ||
    url.pathname.includes('/register') ||
    url.pathname.includes('/logout') ||
    url.pathname.includes('/pair') ||
    url.pathname.includes('/security')
  ) {
    event.respondWith(fetch(event.request));
    return;
  }

  // برای صفحات HTML و پیمایش وب (Navigation Requests)، همواره استراتژی Network-First اجرا می‌شود تا خزنده‌های گوگل و کاربران نسخه زنده را بگیرند
  if (event.request.mode === 'navigate' || (event.request.headers.get('accept') && event.request.headers.get('accept').includes('text/html'))) {
    event.respondWith(
      fetch(event.request)
        .then(response => {
          if (response.status === 200) {
            const copy = response.clone();
            caches.open(CACHE_NAME).then(cache => cache.put(event.request, copy));
          }
          return response;
        })
        .catch(() => caches.match(event.request))
    );
    return;
  }

  // برای فایل‌های استاتیک و فونت‌ها: Cache-First با فال‌بک به شبکه
  event.respondWith(
    caches.match(event.request).then(cachedResponse => {
      if (cachedResponse) {
        return cachedResponse;
      }
      return fetch(event.request).then(networkResponse => {
        if (networkResponse.status === 200) {
          const copy = networkResponse.clone();
          caches.open(CACHE_NAME).then(cache => cache.put(event.request, copy));
        }
        return networkResponse;
      });
    })
  );
});
