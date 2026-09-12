@extends('layouts.public')

@section('title', $guide['title'] . ' | پایگاه دانش طلالایو')
@section('meta_description', $guide['description'])
@section('canonical', 'https://talalive.ir/guides/' . $slug)

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-10">
    <div class="space-y-4">
        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            {{ $guide['title'] }}
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed">{{ $guide['description'] }}</p>
    </div>
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-xl space-y-6 text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed">
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">روش استخراج ارزش ذاتی و حباب سکه</h2>
        <p>حباب سکه نشان‌دهنده میزان تقاضای سفته‌بازی در بازار مسکوکات است. برای مشاهده محاسبات دقیق و زنده، به <a href="{{ route('public.tools.coin-bubble') }}" class="text-amber-500 font-bold underline">محاسبه‌گر آنلاین حباب سکه طلالایو</a> مراجعه نمایید.</p>
    </div>
</div>
@endsection
