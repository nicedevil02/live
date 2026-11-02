@extends('layouts.public')

@section('title', 'تابلو طلا فروشی در شهرهای ایران: مراکز و بازارهای طلا | طلالایو')
@section('meta_description', 'فهرست و معرفی تابلو طلا فروشی و بازارهای زرگری ۱۰ کلان‌شهر ایران: تهران، مشهد، اصفهان، تبریز، شیراز، همدان، یزد، اهواز، قم و رشت با امکان اتصال رایگان تلویزیون.')
@section('canonical', 'https://talalive.ir/cities')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@graph": [
    {
      "@type": "CollectionPage",
      "@id": "https://talalive.ir/cities#webpage",
      "url": "https://talalive.ir/cities",
      "name": "تابلو طلا فروشی در شهرهای ایران: مراکز و بازارهای طلا | طلالایو",
      "description": "فهرست و راهنمای راه‌اندازی تابلو هوشمند طلافروشی در ۱۰ شهر قطب بازار طلا و جواهر کشور.",
      "isPartOf": {
        "@id": "https://talalive.ir/#website"
      },
      "breadcrumb": {
        "@id": "https://talalive.ir/cities#breadcrumb"
      }
    },
    {
      "@type": "BreadcrumbList",
      "@id": "https://talalive.ir/cities#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "صفحه اصلی",
          "item": "https://talalive.ir"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "شهرهای فعال",
          "item": "https://talalive.ir/cities"
        }
      ]
    },
    {
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "آیا تابلوی هوشمند طلالایو در تمام شهرهای ایران کار می‌کند؟",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "بله؛ طلالایو یک سامانه ابری سراسری است و هر طلافروش در هر نقطه از کشور با اتصال تلویزیون مغازه به اینترنت می‌تواند تابلوی اختصاصی گالری خود را با نرخ لحظه‌ای فعال نماید."
          }
        },
        {
          "@type": "Question",
          "name": "آیا امکان تنظیم درصد سود و فرمول محلی متناسب با بخشنامه اتحادیه هر شهر وجود دارد؟",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "بله؛ از طریق پنل مدیریت اختصاصی طلالایو، هر طلافروش می‌تواند فرمول محاسبه طلای ۱۸ عیار، سود قانونی مصوب اتحادیه شهر و نحوه نمایش اقلام را کاملاً شخصی‌سازی کند."
          }
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-16">

    {{-- سربرگ هاب شهرها --}}
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-bold">
            <span>سامانه ابری تابلوی طلا و جواهر در سراسر ایران</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-stone-900 dark:text-white leading-tight">
            تابلو طلا فروشی در شهرهای قطب بازار طلای ایران
        </h1>
        <p class="text-stone-600 dark:text-stone-400 text-sm sm:text-base leading-relaxed">
            گالری‌های طلا و جواهرفروشان محترم در بازارهای بزرگ زرگری کشور می‌توانند تلویزیون مغازه خود را بدون نیاز به مینی‌کیس، کابل‌کشی یا دستگاه اضافه، به تابلوی هوشمند نرخ لحظه‌ای طلالایو متصل کنند.
        </p>
    </div>

    {{-- کارت‌های ۱۰ شهر قطب طلا --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cities as $slug => $c)
        <a href="{{ route('public.cities.hub', $slug) }}" class="p-6 rounded-2xl bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 hover:border-amber-500/50 hover:shadow-md transition-all group flex flex-col justify-between space-y-4">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-amber-600 dark:text-amber-400 bg-amber-500/10 px-3 py-1 rounded-lg">استان {{ $c['province'] ?? $c['name'] }}</span>
                    <span class="text-xs text-stone-400 font-mono">فعال</span>
                </div>
                <h2 class="text-xl font-black text-stone-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
                    تابلو طلا فروشی در {{ $c['name'] }}
                </h2>
                <p class="text-xs text-stone-600 dark:text-stone-400 line-clamp-3 leading-relaxed">
                    {{ Str::limit($c['union_text'] ?? $c['meta_description'], 160) }}
                </p>
            </div>
            <div class="pt-4 border-t border-stone-100 dark:border-stone-800 flex items-center justify-between text-xs font-bold text-amber-600 dark:text-amber-400">
                <span>مشاهده نرخ زنده و بازارهای {{ $c['name'] }}</span>
                <span class="rtl:rotate-180 transform group-hover:translate-x-1 transition-transform">&larr;</span>
            </div>
        </a>
        @endforeach
    </div>

    {{-- بلوک اعتمادسازی و اتصال فوری --}}
    <div class="p-8 sm:p-12 rounded-3xl bg-stone-50 dark:bg-stone-900 border border-stone-200 dark:border-stone-800 text-center space-y-6">
        <h2 class="text-2xl sm:text-3xl font-black text-stone-900 dark:text-white">
            مغازه شما در کدام شهر است؟ همین حالا تابلوی تلویزیونی خود را بسازید
        </h2>
        <p class="text-sm sm:text-base text-stone-600 dark:text-stone-400 max-w-2xl mx-auto leading-relaxed">
            فرقی نمی‌کند در سبزه میدان تهران، بازار خسروی مشهد، راسته مظفریه همدان یا کیانپارس اهواز باشید؛ تابلوی طلالایو روی هر تلویزیون هوشمند با یک اسکن ساده بارکد آماده نمایش است.
        </p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('admin.register') }}" class="min-h-11 inline-flex items-center justify-center px-8 py-3 rounded-2xl bg-amber-500 hover:bg-amber-600 text-stone-950 font-black text-sm transition-all shadow-sm">
                شروع تست ۱۴ روزه رایگان
            </a>
            <a href="{{ route('public.demo') }}" class="min-h-11 inline-flex items-center justify-center px-8 py-3 rounded-2xl border border-stone-300 dark:border-stone-700 bg-white dark:bg-stone-800 text-stone-800 dark:text-stone-200 font-bold text-sm hover:bg-stone-100 dark:hover:bg-stone-700 transition-all">
                مشاهده دموی زنده تابلو
            </a>
        </div>
    </div>

</div>
@endsection
