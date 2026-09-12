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
        <h2 class="text-xl font-bold text-slate-900 dark:text-white">ویژگی‌های پنل مناسب برای ویترین طلافروشی</h2>
        <p>برای تابلوی طلافروشی، روشنایی حداقل ۳۵۰ نیت، پنل ضد انعکاس (Anti-Glare) و زاویه دید گسترده (IPS) اولویت دارند. تلویزیون‌های سامسونگ سری Crystal UHD و ال‌جی سری نانوسل بهترین کارایی را در ویترین دارند. سامانه طلالایو روی مرورگر داخلی تمامی این تلویزیون‌ها بدون نیاز به مینی‌کیس به راحتی اجرا می‌شود.</p>
    </div>
</div>
@endsection
