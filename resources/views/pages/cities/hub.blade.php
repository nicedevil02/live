@extends('layouts.public')

@section('title', $info['title'] ?? ('تابلو طلا فروشی در ' . $info['name'] . ' | طلالایو'))
@section('meta_description', $info['meta_description'] ?? ('سامانه ابری تابلوی هوشمند طلافروشی ویژه گالری‌های طلا و جواهر در شهر ' . $info['name'] . '. نمایش لحظه‌ای نرخ طلا و سکه بدون مینی‌کیس.'))
@section('canonical', 'https://talalive.ir/cities/' . $city)

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "Service",
      "name": "سامانه تابلوی هوشمند طلافروشی در {{ $info['name'] }}",
      "serviceType": "تابلو قیمت طلا و نرخ‌نامه دیجیتال",
      "description": "{{ $info['meta_description'] ?? ('سامانه تابلوی هوشمند طلافروشی در ' . $info['name']) }}",
      "provider": {
        "@@id": "https://talalive.ir/#organization"
      },
      "areaServed": {
        "@@type": "City",
        "name": "{{ $info['name'] }}"
      }
    },
    @if(!empty($info['faqs']) && count($info['faqs']) > 0)
    {
      "@@type": "FAQPage",
      "mainEntity": [
        @foreach($info['faqs'] as $index => $faq)
        {
          "@@type": "Question",
          "name": "{{ $faq['q'] }}",
          "acceptedAnswer": {
            "@@type": "Answer",
            "text": "{{ $faq['a'] }}"
          }
        }@if(!$loop->last),@endif
        @endforeach
      ]
    },
    @endif
    {
      "@@type": "BreadcrumbList",
      "itemListElement": [
        {
          "@@type": "ListItem",
          "position": 1,
          "name": "صفحه اصلی",
          "item": "https://talalive.ir"
        },
        {
          "@@type": "ListItem",
          "position": 2,
          "name": "شهرهای فعال",
          "item": "https://talalive.ir/cities/{{ $city }}"
        },
        {
          "@@type": "ListItem",
          "position": 3,
          "name": "تابلو طلا فروشی در {{ $info['name'] }}",
          "item": "https://talalive.ir/cities/{{ $city }}"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-16">

    {{-- سربرگ و معرفی شهر --}}
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-bold">
            <span>سامانه ابری تابلوی طلا و جواهر در استان {{ $info['province'] ?? $info['name'] }}</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 dark:text-white leading-tight">
            تابلو طلا فروشی در {{ $info['name'] }}
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed">
            گالری‌های طلا و جواهرفروشان محترم شهر {{ $info['name'] }} می‌توانند بدون نیاز به خرید تابلوهای سنتی LED، مینی‌کیس یا تجهیزات جانبی، تلویزیون مغازه را به تابلوی هوشمند نرخ لحظه‌ای طلالایو متصل کنند.
        </p>
    </div>

    {{-- بخش ۱: نرخ زنده طلا و مسکوکات در بازار --}}
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>نرخ زنده و لحظه‌ای بازار طلا و مسکوکات در {{ $info['name'] }}</span>
            </h2>
            <span class="text-xs text-slate-500 font-mono" dir="ltr">{{ date('H:i') }}</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            {{-- طلای ۱۸ عیار --}}
            <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-1 text-right">
                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold block">طلای ۱۸ عیار (گرم)</span>
                <span class="text-base sm:text-xl font-black text-amber-500 font-mono block" dir="ltr">
                    {{ !empty($rates['gold18']) && $rates['gold18'] > 0 ? number_format($rates['gold18']) : '۴,۶۵۰,۰۰۰' }}
                </span>
                <span class="text-[10px] text-slate-400">تومان</span>
            </div>

            {{-- مثقال ۱۷ عیار --}}
            <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-1 text-right">
                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold block">مظنه مثقال ۱۷</span>
                <span class="text-base sm:text-xl font-black text-slate-800 dark:text-slate-200 font-mono block" dir="ltr">
                    {{ !empty($rates['mesghal']) && $rates['mesghal'] > 0 ? number_format($rates['mesghal']) : '۲۰,۱۴۰,۰۰۰' }}
                </span>
                <span class="text-[10px] text-slate-400">تومان</span>
            </div>

            {{-- سکه امامی --}}
            <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-1 text-right">
                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold block">سکه تمام امامی</span>
                <span class="text-base sm:text-xl font-black text-amber-500 font-mono block" dir="ltr">
                    {{ !empty($rates['coin_emami']) && $rates['coin_emami'] > 0 ? number_format($rates['coin_emami']) : '۵۲,۸۰۰,۰۰۰' }}
                </span>
                <span class="text-[10px] text-slate-400">تومان</span>
            </div>

            {{-- انس طلا --}}
            <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm space-y-1 text-right">
                <span class="text-[11px] text-slate-500 dark:text-slate-400 font-bold block">انس جهانی طلا</span>
                <span class="text-base sm:text-xl font-black text-slate-800 dark:text-slate-200 font-mono block" dir="ltr">
                    {{ !empty($rates['ons']) && $rates['ons'] > 0 ? '$ ' . number_format($rates['ons'], 1) : '$ ۲,۷۳۵.۵' }}
                </span>
                <span class="text-[10px] text-slate-400">دلار</span>
            </div>
        </div>
    </div>

    {{-- بخش ۲: بلوک نرخ اتحادیه طلا و جواهر شهر (فقط در صورت وجود محتوای اختصاصی) --}}
    @if(!empty($info['union_text']))
    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xl space-y-4">
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-2xl bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black text-lg">⚖️</span>
            <h2 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">
                {{ $info['union_title'] ?? ('نرخ اتحادیه طلا و جواهر ' . $info['name'] . ' و تفاوت با مظنه تهران') }}
            </h2>
        </div>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
            {{ $info['union_text'] }}
        </p>
    </div>
    @endif

    {{-- بخش ۳: معرفی راسته و بازار طلای شهر (فقط در صورت وجود محتوای اختصاصی) --}}
    @if(!empty($info['bazaar_text']))
    <div class="p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xl space-y-4">
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-2xl bg-blue-500/10 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 flex items-center justify-center font-black text-lg">🏛️</span>
            <h2 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">
                {{ $info['bazaar_title'] ?? ('راسته و بازارهای طلای ' . $info['name']) }}
            </h2>
        </div>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
            {{ $info['bazaar_text'] }}
        </p>
    </div>
    @endif

    {{-- بخش ۴: فهرست گالری‌های فعال طلالایو در شهر (فقط در صورت وجود محتوای اختصاصی) --}}
    @if(!empty($info['galleries']) && count($info['galleries']) > 0)
    <div class="space-y-6">
        <div class="space-y-2">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                <span>گالری‌های فعال طلالایو در شهر {{ $info['name'] }}</span>
            </h2>
            <p class="text-xs sm:text-sm text-slate-500">مشاهده تابلوی آنلاین و ویترین گالری‌های مجهز به سامانه طلالایو</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($info['galleries'] as $gallery)
            <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-sm hover:border-amber-500/40 transition-colors">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $gallery['name'] }}</span>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-[10px] font-bold">فعال</span>
                </div>
                <p class="text-[11px] text-slate-500 leading-relaxed">{{ $gallery['address'] }}</p>
                <div class="pt-1">
                    <a href="/{{ $gallery['username'] }}" class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:underline inline-flex items-center gap-1">
                        <span>مشاهده تابلوی زنده گالری</span>
                        <span>←</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- بخش ۵: سؤالات متداول اختصاصی شهر (فقط در صورت وجود محتوای اختصاصی) --}}
    @if(!empty($info['faqs']) && count($info['faqs']) > 0)
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6">
        <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
            پرسش‌های متداول طلافروشان {{ $info['name'] }}
        </h2>
        <div class="space-y-3">
            @foreach($info['faqs'] as $faq)
            <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 space-y-2">
                <strong class="text-xs sm:text-sm text-slate-900 dark:text-white font-bold block">
                    {{ $faq['q'] }}
                </strong>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    {{ $faq['a'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- فراخوان ثبت‌نام ویژه طلافروشان این شهر --}}
    @include('partials.cta-inline', [
        'title' => 'راه‌اندازی تابلوی گالری طلا در ' . $info['name'] . ' در کمتر از ۶۰ ثانیه',
        'subtitle' => 'همین حالا تلویزیون مغازه را بدون خرید دستگاه جانبی به مدرن‌ترین تابلوی نرخ طلا مجهز کنید. با ۱۴ روز تست کاملاً رایگان.',
        'buttonText' => 'تست رایگان تابلوی طلا',
        'buttonUrl' => route('admin.register')
    ])

    {{-- مطالب مرتبط و ابزارهای صنف طلا --}}
    @include('partials.related-links', [
        'links' => [
            [
                'url' => '/smart-gold-board',
                'title' => 'تابلوی هوشمند طلافروشی روی تلویزیون',
                'desc' => 'سامانه ابری نمایش نرخ لحظه‌ای طلا و سکه بدون نیاز به خرید مینی‌کیس.'
            ],
            [
                'url' => '/digital-rate-board',
                'title' => 'نرخ نامه دیجیتال طلافروشی',
                'desc' => 'جایگزین تابلوی ۷ رقمه سون سگمنت با ۷ ردیف نرخ زنده و فرمول سود.'
            ],
            [
                'url' => '/tv-setup-guide',
                'title' => 'راهنمای اتصال تلویزیون مغازه',
                'desc' => 'آموزش گام‌به‌گام اتصال مرورگر تلویزیون سامسونگ، ال‌جی یا اندرویدی به تابلو.'
            ]
        ]
    ])

</div>
@endsection
