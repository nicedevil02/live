<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به پنل مدیریت | طلالایو</title>
    <meta name="description" content="ورود به پنل مدیریت سامانه تابلوی زنده طلا و سکه طلالایو.">
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

            @if (session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 text-emerald-600 dark:text-emerald-400 rounded-xl p-3 mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800/50 text-rose-600 dark:text-rose-400 rounded-xl p-3 mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="mt-3 grid gap-3">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1">شناسه ورود (شماره موبایل، نام کاربری یا ایمیل)</label>
                    <input type="text" name="email" required
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm"
                           placeholder="مثال: 09187009064 یا نام کاربری" value="{{ old('email') }}">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1">رمز عبور</label>
                    <input type="password" name="password" required
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm"
                           placeholder="رمز عبور">
                </div>
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition-colors">
                    ورود
                </button>
            </form>
            
            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 text-center">
                <span class="text-xs text-slate-500">طلافروشی جدید هستید؟</span>
                <a href="{{ route('admin.register') }}" class="text-xs font-bold text-blue-600 hover:underline mr-1">ثبت نام کنید</a>
            </div>
        </div>
    </div>
</body>
</html>
