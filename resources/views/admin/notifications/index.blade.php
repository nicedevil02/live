@extends('admin.layouts.app')

@section('title', 'اطلاع‌رسانی ربات بله و تلگرام')

@section('content')
<div class="max-w-5xl mx-auto space-y-6" x-data="botNotificationPage()">
    {{-- هدر صفحه --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-stone-900 p-6 rounded-2xl border border-slate-200 dark:border-stone-800 shadow-sm">
        <div>
            <h1 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white flex items-center gap-2.5">
                <i data-lucide="send" class="w-5 h-5 text-amber-500 shrink-0"></i>
                <span>اطلاع‌رسانی ربات بله و تلگرام</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-stone-400 mt-1.5 leading-relaxed">
                بلافاصله پس از ثبت‌نام کاربر جدید یا ثبت درخواست تماس و راه‌اندازی کارشناس، مشخصات گالری و شماره تماس به‌صورت غیرمسدودکننده به پیام‌رسان‌های زیر ارسال می‌شود.
            </p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="min-h-[44px] px-4 py-2 text-xs font-bold bg-slate-100 hover:bg-slate-200 dark:bg-stone-800 dark:hover:bg-stone-700 text-slate-700 dark:text-stone-300 rounded-xl transition-colors inline-flex items-center justify-center shrink-0">
            ← بازگشت به داشبورد
        </a>
    </div>

    {{-- پیام‌های وضعیت --}}
    @if(session('success'))
        <div class="p-4 rounded-2xl border bg-emerald-500/10 border-emerald-500/30 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm font-bold flex items-center gap-2.5">
            <i data-lucide="check-circle-2" class="w-5 h-5 shrink-0 text-emerald-500"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-2xl border bg-rose-500/10 border-rose-500/30 text-rose-800 dark:text-rose-300 text-xs sm:text-sm font-bold flex items-center gap-2.5">
            <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 text-rose-500"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="p-4 rounded-2xl border bg-rose-500/10 border-rose-500/30 text-rose-800 dark:text-rose-300 text-xs sm:text-sm space-y-1">
            @foreach($errors->all() as $error)
                <p class="font-bold">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- بازخورد دریافت خودکار Chat ID --}}
    <div x-show="detectStatus.text" x-cloak
         :class="detectStatus.ok ? 'bg-emerald-500/10 border-emerald-500/30 text-emerald-800 dark:text-emerald-300' : 'bg-amber-500/10 border-amber-500/30 text-amber-800 dark:text-amber-300'"
         class="p-4 rounded-2xl border text-xs sm:text-sm font-bold"
         x-text="detectStatus.text"></div>

    {{-- فرم تنظیمات اصلی --}}
    <form method="POST" action="{{ route('admin.notifications.update') }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- کلید کلی اطلاع‌رسانی ثبت‌نام --}}
        <div class="bg-white dark:bg-stone-900 p-5 rounded-2xl border border-slate-200 dark:border-stone-800 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">اطلاع‌رسانی هنگام ثبت‌نام کاربر جدید</h2>
                <p class="text-xs text-slate-500 dark:text-stone-400 mt-1">
                    ارسال خودکار نام گالری، شماره موبایل، شهر، نام کاربری و لینک تابلو بلافاصله پس از ثبت‌نام.
                </p>
            </div>
            <label class="inline-flex items-center gap-3 cursor-pointer select-none min-h-[44px]">
                <input type="checkbox" name="notify_on_register" value="1"
                       {{ old('notify_on_register', $config['notify_on_register']) ? 'checked' : '' }}
                       class="w-5 h-5 rounded accent-amber-500">
                <span class="text-sm font-black text-slate-800 dark:text-stone-200">فعال باشد</span>
            </label>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- کارت ربات بله --}}
            @php $bale = $config['platforms']['bale']; @endphp
            <div class="bg-white dark:bg-stone-900 p-6 rounded-2xl border border-slate-200 dark:border-stone-800 shadow-sm space-y-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full {{ $bale['enabled'] && $bale['configured'] ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                            <span>ربات بله (Bale)</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-stone-400 mt-1">
                            اتصال مستقیم و پایدار روی سرورهای ایران (`tapi.bale.ai`)
                        </p>
                    </div>
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none min-h-[44px]">
                        <input type="checkbox" name="bale_enabled" value="1"
                               {{ old('bale_enabled', $bale['enabled']) ? 'checked' : '' }}
                               class="w-5 h-5 rounded accent-emerald-500">
                        <span class="text-xs font-black text-slate-700 dark:text-stone-200">فعال</span>
                    </label>
                </div>

                <div>
                    <label for="bale_bot_token" class="block text-xs font-bold text-slate-700 dark:text-stone-300 mb-1.5">
                        توکن ربات بله (از BotFather در بله)
                    </label>
                    <input type="password" id="bale_bot_token" name="bale_bot_token" x-model="baleToken" autocomplete="new-password" dir="ltr"
                           placeholder="{{ $tokenPreviews['bale'] ? 'توکن فعلی ذخیره شده: ' . $tokenPreviews['bale'] . ' (خالی = بدون تغییر)' : 'مثال: 1234567890:ABCdef...' }}"
                           class="w-full min-h-[44px] px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-stone-800 border border-slate-200 dark:border-stone-700 text-xs sm:text-sm font-mono text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @if($tokenPreviews['bale'])
                        <label class="mt-2 inline-flex items-center gap-2 text-[11px] text-rose-600 dark:text-rose-400 cursor-pointer">
                            <input type="checkbox" name="clear_bale_token" value="1" class="rounded accent-rose-500">
                            <span>حذف توکن ذخیره‌شده بله</span>
                        </label>
                    @endif
                </div>

                <div>
                    <div class="flex items-center justify-between gap-2 mb-1.5">
                        <label for="bale_chat_id" class="block text-xs font-bold text-slate-700 dark:text-stone-300">
                            شناسه عددی چت یا کانال (Chat ID)
                        </label>
                        <button type="button" @click="detect('bale')" :disabled="detectLoading === 'bale'"
                                class="text-[11px] font-black text-amber-600 dark:text-amber-400 hover:underline cursor-pointer disabled:opacity-50">
                            <span x-show="detectLoading !== 'bale'">🔍 دریافت خودکار از آخرین /start</span>
                            <span x-show="detectLoading === 'bale'" x-cloak>در حال استعلام...</span>
                        </button>
                    </div>
                    <input type="text" id="bale_chat_id" name="bale_chat_id" x-model="baleChatId" dir="ltr"
                           placeholder="مثال: 471164093"
                           class="w-full min-h-[44px] px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-stone-800 border border-slate-200 dark:border-stone-700 text-xs sm:text-sm font-mono text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                @if(!empty($bale['last_status']))
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-stone-800/70 border border-slate-200/80 dark:border-stone-700 text-[11px] text-slate-600 dark:text-stone-300 leading-relaxed break-words">
                        <strong>آخرین وضعیت:</strong> {{ $bale['last_status'] }}
                    </div>
                @endif
            </div>

            {{-- کارت ربات تلگرام --}}
            @php $tg = $config['platforms']['telegram']; @endphp
            <div class="bg-white dark:bg-stone-900 p-6 rounded-2xl border border-slate-200 dark:border-stone-800 shadow-sm space-y-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full {{ $tg['enabled'] && $tg['configured'] ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                            <span>ربات تلگرام (Telegram)</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-stone-400 mt-1">
                            نیازمند رله واسط (Cloudflare Worker) روی هاست‌های داخل ایران
                        </p>
                    </div>
                    <label class="inline-flex items-center gap-2 cursor-pointer select-none min-h-[44px]">
                        <input type="checkbox" name="telegram_enabled" value="1"
                               {{ old('telegram_enabled', $tg['enabled']) ? 'checked' : '' }}
                               class="w-5 h-5 rounded accent-emerald-500">
                        <span class="text-xs font-black text-slate-700 dark:text-stone-200">فعال</span>
                    </label>
                </div>

                <div>
                    <label for="telegram_bot_token" class="block text-xs font-bold text-slate-700 dark:text-stone-300 mb-1.5">
                        توکن ربات تلگرام (از @BotFather)
                    </label>
                    <input type="password" id="telegram_bot_token" name="telegram_bot_token" x-model="tgToken" autocomplete="new-password" dir="ltr"
                           placeholder="{{ $tokenPreviews['telegram'] ? 'توکن فعلی ذخیره شده: ' . $tokenPreviews['telegram'] . ' (خالی = بدون تغییر)' : 'مثال: 7123456789:AA...' }}"
                           class="w-full min-h-[44px] px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-stone-800 border border-slate-200 dark:border-stone-700 text-xs sm:text-sm font-mono text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    @if($tokenPreviews['telegram'])
                        <label class="mt-2 inline-flex items-center gap-2 text-[11px] text-rose-600 dark:text-rose-400 cursor-pointer">
                            <input type="checkbox" name="clear_telegram_token" value="1" class="rounded accent-rose-500">
                            <span>حذف توکن ذخیره‌شده تلگرام</span>
                        </label>
                    @endif
                </div>

                <div>
                    <div class="flex items-center justify-between gap-2 mb-1.5">
                        <label for="telegram_chat_id" class="block text-xs font-bold text-slate-700 dark:text-stone-300">
                            شناسه عددی چت یا کانال (Chat ID)
                        </label>
                        <button type="button" @click="detect('telegram')" :disabled="detectLoading === 'telegram'"
                                class="text-[11px] font-black text-amber-600 dark:text-amber-400 hover:underline cursor-pointer disabled:opacity-50">
                            <span x-show="detectLoading !== 'telegram'">🔍 دریافت خودکار از آخرین /start</span>
                            <span x-show="detectLoading === 'telegram'" x-cloak>در حال استعلام...</span>
                        </button>
                    </div>
                    <input type="text" id="telegram_chat_id" name="telegram_chat_id" x-model="tgChatId" dir="ltr"
                           placeholder="مثال: 123456789 یا -100..."
                           class="w-full min-h-[44px] px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-stone-800 border border-slate-200 dark:border-stone-700 text-xs sm:text-sm font-mono text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>

                <div>
                    <label for="telegram_api_base" class="block text-xs font-bold text-slate-700 dark:text-stone-300 mb-1.5">
                        آدرس پایه یا رله تلگرام (API Base URL)
                    </label>
                    <input type="url" id="telegram_api_base" name="telegram_api_base" x-model="tgApiBase" dir="ltr"
                           placeholder="https://api.telegram.org"
                           class="w-full min-h-[44px] px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-stone-800 border border-slate-200 dark:border-stone-700 text-xs sm:text-sm font-mono text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <details class="mt-2.5 rounded-xl border border-slate-200 dark:border-stone-700 bg-slate-50 dark:bg-stone-800/60 p-3 text-xs">
                        <summary class="font-bold text-slate-700 dark:text-stone-200 cursor-pointer select-none">
                            کد رایگان Cloudflare Worker برای عبور تلگرام از هاست ایران
                        </summary>
                        <div class="mt-2.5 space-y-2 text-[11px] text-slate-600 dark:text-stone-300 leading-relaxed">
                            <p>یک Worker جدید در کلادفلر بسازید، کد زیر را داخل آن قرار دهید و آدرس `.workers.dev` آن را بالا وارد کنید:</p>
                            <pre class="p-2.5 rounded-lg bg-slate-900 text-slate-100 font-mono text-[11px] overflow-x-auto" dir="ltr">export default {
  async fetch(request) {
    const url = new URL(request.url);
    url.hostname = "api.telegram.org";
    return fetch(new Request(url, request));
  }
};</pre>
                        </div>
                    </details>
                </div>

                @if(!empty($tg['last_status']))
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-stone-800/70 border border-slate-200/80 dark:border-stone-700 text-[11px] text-slate-600 dark:text-stone-300 leading-relaxed break-words">
                        <strong>آخرین وضعیت:</strong> {{ $tg['last_status'] }}
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="w-full sm:w-auto min-h-[46px] px-8 py-3 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-sm shadow-md shadow-amber-500/20 transition-all cursor-pointer">
                ذخیره تنظیمات ربات‌ها
            </button>
        </div>
    </form>

    {{-- بخش تست ارسال زنده --}}
    <div class="bg-white dark:bg-stone-900 p-6 rounded-2xl border border-slate-200 dark:border-stone-800 shadow-sm space-y-4">
        <div>
            <h2 class="text-sm sm:text-base font-black text-slate-900 dark:text-white">تست زنده ارسال پیام اطلاع‌رسانی</h2>
            <p class="text-xs text-slate-500 dark:text-stone-400 mt-1">
                ابتدا تغییرات بالا را ذخیره کنید، سپس با دکمه‌های زیر یک پیام نمونه به بله یا تلگرام بفرستید تا از رسیدن پیام مطمئن شوید.
            </p>
        </div>
        <div class="flex flex-wrap gap-3">
            <form method="POST" action="{{ route('admin.notifications.test') }}">
                @csrf
                <input type="hidden" name="platform" value="bale">
                <button type="submit" class="min-h-[44px] px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs sm:text-sm transition-colors cursor-pointer">
                    ارسال تست در بله
                </button>
            </form>
            <form method="POST" action="{{ route('admin.notifications.test') }}">
                @csrf
                <input type="hidden" name="platform" value="telegram">
                <button type="submit" class="min-h-[44px] px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-black text-xs sm:text-sm transition-colors cursor-pointer">
                    ارسال تست در تلگرام
                </button>
            </form>
            <form method="POST" action="{{ route('admin.notifications.test') }}">
                @csrf
                <input type="hidden" name="platform" value="both">
                <button type="submit" class="min-h-[44px] px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 dark:bg-stone-700 dark:hover:bg-stone-600 text-white font-black text-xs sm:text-sm transition-colors cursor-pointer">
                    تست هم‌زمان هر دو
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function botNotificationPage() {
    return {
        baleToken: '',
        baleChatId: @json(old('bale_chat_id', $config['platforms']['bale']['chat_id'] ?? '')),
        tgToken: '',
        tgChatId: @json(old('telegram_chat_id', $config['platforms']['telegram']['chat_id'] ?? '')),
        tgApiBase: @json(old('telegram_api_base', $config['platforms']['telegram']['api_base'] ?? 'https://api.telegram.org')),
        detectLoading: '',
        detectStatus: { ok: false, text: '' },

        async detect(platform) {
            this.detectLoading = platform;
            this.detectStatus = { ok: false, text: '' };
            try {
                const body = {
                    platform,
                    bot_token: platform === 'bale' ? this.baleToken : this.tgToken,
                    api_base: platform === 'telegram' ? this.tgApiBase : null,
                };
                const res = await fetch(@json(route('admin.notifications.detect-chat-id')), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': @json(csrf_token()),
                    },
                    body: JSON.stringify(body),
                });
                const data = await res.json();
                this.detectStatus = { ok: Boolean(data.success), text: data.message || '' };
                if (data.success && data.chat_id) {
                    if (platform === 'bale') {
                        this.baleChatId = data.chat_id;
                    } else {
                        this.tgChatId = data.chat_id;
                    }
                }
            } catch (e) {
                this.detectStatus = { ok: false, text: 'خطا در ارتباط با سرور برای دریافت Chat ID.' };
            } finally {
                this.detectLoading = '';
            }
        },
    };
}
</script>
@endsection
