<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود ادمین - Live Gold</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
</head>
<body class="bg-slate-100 dark:bg-slate-950 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md mx-4">
        {{-- عنوان (مطابق AdminHeader) --}}
        <div class="mb-4 flex items-center justify-between gap-3">
            <h1 class="text-lg font-bold text-slate-800 dark:text-white">ورود ادمین</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">پنل مدیریت Live Gold</p>
        </div>

        {{-- GlassCard شبیه‌سازی‌شده --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mb-1">ورود به پنل مدیریت</h3>

            @if ($errors->any())
                <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800/50 text-rose-600 dark:text-rose-400 rounded-xl p-3 mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="mt-3 grid gap-3">
                @csrf
                <input type="email" name="email" required
                       class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm"
                       placeholder="ایمیل" value="{{ old('email', 'admin@gold.test') }}">
                <input type="password" name="password" required
                       class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm"
                       placeholder="رمز عبور">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition-colors">
                    ورود
                </button>
            </form>
        </div>
    </div>
</body>
</html>
