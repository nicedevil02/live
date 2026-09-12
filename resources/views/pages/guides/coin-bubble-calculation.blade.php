@extends('layouts.public')

@section('title', $guide['title'] . ' | پایگاه دانش طلالایو')
@section('meta_description', $guide['description'])
@section('canonical', 'https://talalive.ir/guides/' . $slug)

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "Article",
      "headline": "{{ $guide['title'] }}",
      "description": "{{ $guide['description'] }}",
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
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-10">
    <div class="space-y-4">
        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            {{ $guide['title'] }}
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed">{{ $guide['description'] }}</p>
    </div>
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6 text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">روش استخراج ارزش ذاتی و فرمول حباب سکه، نیم‌سکه و ربع‌سکه</h2>
        <p>حباب سکه نشان‌دهنده میزان تقاضای سفته‌بازی در بازار مسکوکات است. فرمول محاسبه ارزش ذاتی سکه بر اساس وزن طلای خالص موجود در آن، عیار ۹۰۰ (۲۱.۶ عیار)، نرخ اونس جهانی طلا و دلار آزاد به دست می‌آید. برای انواع مسکوکات از جمله تمام بهار، سکه امامی، نیم سکه (نیم‌سکه)، ربع سکه (ربع‌سکه) و سکه گرمی، ارزش طلای خام محاسبه شده و از قیمت بازاری کسر می‌گردد.</p>
        <p>برای مشاهده محاسبات دقیق، درصد حباب و نمودار زنده، به <a href="{{ route('public.tools.coin-bubble') }}" class="text-amber-500 font-bold underline">محاسبه‌گر آنلاین حباب سکه و حباب‌سنج طلالایو</a> مراجعه نمایید.</p>
    </div>
</div>
@endsection
