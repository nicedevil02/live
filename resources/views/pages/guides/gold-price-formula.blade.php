@extends('layouts.public')

@section('title', $guide['title'] . ' | پایگاه دانش طلالایو')
@section('meta_description', $guide['description'])
@section('canonical', 'https://talalive.ir/guides/' . $slug)
@section('og_image', asset($guide['image']))
@section('og_image_alt', $guide['title'])

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "Article",
      "headline": "{{ $guide['title'] }}",
      "description": "{{ $guide['description'] }}",
      "image": [
        "{{ url($guide['image']) }}"
      ],
      "datePublished": "2025-09-10",
      "dateModified": "2026-09-12",
      "author": {
        "@@type": "Organization",
        "name": "تیم تحریریه طلالایو"
      },
      "publisher": {
        "@@id": "https://talalive.ir/#organization"
      }
    },
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
          "name": "پایگاه دانش طلا",
          "item": "https://talalive.ir/guides"
        },
        {
          "@@type": "ListItem",
          "position": 3,
          "name": "{{ $guide['title'] }}",
          "item": "https://talalive.ir/guides/{{ $slug }}"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-8 sm:py-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-8">

    @include('partials.breadcrumb', [
        'items' => [
            ['title' => 'پایگاه دانش طلا', 'url' => route('public.guides')],
            ['title' => $guide['title']],
        ]
    ])

    <div class="space-y-4">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/10 text-amber-700 dark:text-amber-300 text-xs font-bold border border-amber-500/20">
            <span>تاریخ انتشار: {{ $guide['date'] }}</span>
        </div>
        <h1 class="text-2xl sm:text-4xl font-black text-stone-900 dark:text-white leading-tight">
            {{ $guide['title'] }}
        </h1>
        <p class="text-stone-600 dark:text-stone-400 text-sm sm:text-base leading-relaxed">
            {{ $guide['description'] }}
        </p>
    </div>

    {{-- تصویر شاخص راهنما با کیفیت عالی سئو و استانداردهای Core Web Vitals --}}
    <figure class="relative rounded-3xl overflow-hidden border border-amber-500/25 dark:border-stone-800 shadow-xl aspect-[16/9] bg-stone-900 group">
        <img src="{{ asset($guide['image']) }}" 
             alt="{{ $guide['title'] }}" 
             width="1200" height="675" 
             loading="eager" fetchpriority="high" decoding="async"
             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.01]">
    </figure>

    <div class="bg-white dark:bg-stone-900 border border-stone-200 dark:border-stone-800 rounded-3xl p-6 sm:p-10 shadow-sm space-y-6 text-sm sm:text-base text-stone-700 dark:text-stone-300 leading-relaxed">
        <h2 class="text-xl font-bold text-stone-900 dark:text-white">فرمول استاندارد محاسبه قیمت طلا در مغازه طلا فروشی</h2>
        <p>
            یکی از مهم‌ترین چالش‌های خریداران و فروشندگان در مغازه طلا فروشی، نحوه دقیق محاسبه فاکتور نهایی طلا بر اساس آخرین مقررات مالیاتی است. طبق قانون مصوب اتحادیه، اصل طلا از پرداخت هرگونه مالیات معاف است و مالیات ارزش افزوده (۹ درصد) منحصراً به <strong>مجموع اجرت ساخت و سود طلا فروشی</strong> تعلق می‌گیرد.
        </p>
        <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20 text-xs sm:text-sm font-mono dir-ltr text-center font-bold text-amber-700 dark:text-amber-300">
            قیمت نهایی = وزن × [ نرخ خام ۱۸ عیار + اجرت ] + سود ۷٪ + ۹٪ مالیات (روی اجرت و سود)
        </div>
        <p>
            همچنین در صورت خرید و فروش <strong>طلای دست دوم</strong> یا <strong>طلای کم‌اجرت</strong>، اجرت ساخت به ترتیب صفر یا حداقل (بین ۳ تا ۷ درصد) لحاظ شده و تنها سود مصوب فروشنده محاسبه می‌گردد.
        </p>
        <p>
            برای سادگی محاسبات، می‌توانید از <a href="{{ route('public.tools.gold-price') }}" class="text-amber-700 dark:text-amber-400 font-bold underline">ماشین حساب طلا و محاسبه‌گر قیمت طلای طلالایو</a> استفاده فرمایید. همچنین اگر مایلید این قیمت‌ها با فرمول و سود قانونی شما مستقیماً روی <strong>تابلو طلا فروشی</strong> و تلویزیون گالری پخش شوند، سامانه ابری طلالایو این فرایند را تمام‌خودکار انجام می‌دهد.
        </p>
    </div>

</div>
@endsection
