<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ثبت نام طلافروشی جدید | طلالایو</title>
    <meta name="description" content="ثبت‌نام و راه‌اندازی تابلوی اختصاصی هوشمند نرخ طلا و سکه برای گالری طلافروشی در سامانه طلالایو.">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('fonts/vazirmatn.css') }}">
</head>
<body class="bg-slate-100 dark:bg-slate-950 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md mx-4 my-8">
        {{-- عنوان --}}
        <div class="mb-4 flex items-center justify-between gap-3">
            <h1 class="text-lg font-bold text-slate-800 dark:text-white">عضویت طلافروشی جدید</h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">پنل مدیریت Live Gold</p>
        </div>

        {{-- GlassCard --}}
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mb-1">ایجاد حساب کاربری مغازه</h3>
            <p class="text-xs text-slate-500 mb-4">اطلاعات فروشگاه خود را وارد کنید تا تابلوی اختصاصی شما ساخته شود.</p>

            @if ($errors->any())
                <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200 dark:border-rose-800/50 text-rose-600 dark:text-rose-400 rounded-xl p-3 mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.register') }}" class="grid gap-3">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">نام طلافروشی / گالری</label>
                    <input type="text" name="name" id="shopNameInput" required
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm"
                           placeholder="مثال: گالری طلای بهمن" value="{{ old('name') }}">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">شناسه یکتای آدرس وب (فقط حروف انگلیسی و خط تیره)</label>
                    <input type="text" name="username" id="usernameInput" required
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-left font-mono"
                           dir="ltr" placeholder="مثال: bahman-gold" value="{{ old('username') }}">
                    <p class="text-[10px] text-slate-400 mt-1">آدرس تلویزیون شما خواهد شد: talalive.ir/bahman-gold</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">ایمیل (نام کاربری جهت ورود)</label>
                    <input type="email" name="email" required
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm text-left font-mono"
                           dir="ltr" placeholder="email@example.com" value="{{ old('email') }}">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">رمز عبور (حداقل ۶ کاراکتر)</label>
                    <input type="password" name="password" required
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm"
                           placeholder="رمز عبور">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 mb-1">تکرار رمز عبور</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm"
                           placeholder="تکرار رمز عبور">
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition-colors mt-2">
                    ثبت نام و ایجاد مغازه
                </button>
            </form>

            <div class="mt-4 pt-4 border-t border-slate-100 dark:border-slate-800 text-center">
                <span class="text-xs text-slate-500">قبلاً ثبت نام کرده‌اید؟</span>
                <a href="{{ route('admin.login') }}" class="text-xs font-bold text-blue-600 hover:underline mr-1">وارد شوید</a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nameInput = document.getElementById('shopNameInput');
            const usernameInput = document.getElementById('usernameInput');

            function transliterate(str) {
                const map = {
                    'آ': 'a', 'ا': 'a', 'ب': 'b', 'پ': 'p', 'ت': 't', 'ث': 's', 'ج': 'j', 'چ': 'ch', 'ح': 'h', 'خ': 'kh',
                    'د': 'd', 'ذ': 'z', 'ر': 'r', 'ز': 'z', 'ژ': 'zh', 'س': 's', 'ش': 'sh', 'ص': 's', 'ض': 'z', 'ط': 't',
                    'ظ': 'z', 'ع': 'a', 'غ': 'gh', 'ف': 'f', 'ق': 'gh', 'ک': 'k', 'گ': 'g', 'ل': 'l', 'م': 'm', 'ن': 'n',
                    'و': 'u', 'ه': 'h', 'ی': 'y', 'ئ': 'y', ' ': '-', '‌': '-'
                };
                return str.toLowerCase().split('').map(char => {
                    if (map[char] !== undefined) return map[char];
                    if (/[a-z0-9\-]/.test(char)) return char;
                    return '';
                }).join('').replace(/-+/g, '-').replace(/^-|-$/g, '');
            }

            nameInput.addEventListener('input', () => {
                usernameInput.value = transliterate(nameInput.value);
            });
        });
    </script>
</body>
</html>
