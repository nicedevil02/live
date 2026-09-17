@extends('layouts.public')

@section('title', config('seo.pages.guides/gold-hallmark-inquiry.title'))
@section('meta_description', config('seo.pages.guides/gold-hallmark-inquiry.desc'))
@section('canonical', 'https://talalive.ir/guides/gold-hallmark-inquiry')

@section('schema')
@include('partials.schema-article', [
    'headline' => config('seo.pages.guides/gold-hallmark-inquiry.title'),
    'description' => config('seo.pages.guides/gold-hallmark-inquiry.desc'),
    'datePublished' => '2026-04-11',
    'dateModified' => '2026-04-11',
])
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-12">

    {{-- خرده‌نان (Breadcrumb) --}}
    @include('partials.breadcrumb', [
        'items' => [
            ['title' => 'پایگاه دانش طلالایو', 'url' => route('public.guides')],
            ['title' => 'استعلام انگ طلا و ری‌گیری', 'url' => route('public.guides.show', 'gold-hallmark-inquiry')],
        ]
    ])

    <article class="space-y-10">

        {{-- هدر مقاله با تعریف صریح موضوع در ۴۰ کلمه اول --}}
        <header class="space-y-4 border-b border-slate-200 dark:border-slate-800 pb-8">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-bold">
                <span>راهنمای فنی معاملات طلای آبشده • بروزرسانی ۱۴۰۵</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
                استعلام انگ طلا و راهنمای خواندن عیار و شماره پاکت ری‌گیری
            </h1>
            <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed text-justify">
                استعلام انگ طلا فرآیند بررسی و اعتبارسنجی کد شناسایی و عیار رسمی حک‌شده روی قطعه طلای آبشده از طریق سامانه استعلام آزمایشگاه‌های ری‌گیری زیر نظر اتحادیه طلا و جواهر است.
            </p>
            <div class="flex items-center gap-4 text-xs text-slate-400 pt-2">
                <span>نویسنده: تیم پژوهش بازار طلالایو</span>
                <span>•</span>
                <span>زمان مطالعه: ۶ دقیقه</span>
                <span>•</span>
                <span>تاریخ انتشار: فروردین ۱۴۰۵</span>
            </div>
        </header>

        {{-- سلب مسئولیت صریح E-E-A-T و خط قرمز عدم ادعای اعتبارسنجی رسمی --}}
        <div class="p-5 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-amber-800 dark:text-amber-300 text-xs sm:text-sm leading-relaxed space-y-2">
            <div class="font-bold flex items-center gap-2 text-amber-900 dark:text-amber-200">
                <span>⚠️</span>
                <span>اطلاعیه مهم حقوقی و صنفی پیرامون استعلام عیار:</span>
            </div>
            <p>
                سامانه نرم‌افزاری طلالایو صرفاً ارائه‌دهنده ابزارهای محاسباتی نرخ و تابلوی هوشمند قیمت برای مغازه‌های طلافروشی است و هیچ‌گونه ادعا، صلاحیت یا خدمتی در زمینه اعتبارسنجی رسمی، ری‌گیری یا تأیید اصالت شمش و آبشده ندارد. مرجع انحصاری صدور و تأیید انگ، آزمایشگاه‌های رسمی ری‌گیری دارای پروانه کسب زیر نظر اتحادیه طلا و جواهر سراسر کشور هستند.
            </p>
        </div>

        {{-- بخش H2 اول: انگ طلا چیست --}}
        <div class="space-y-4">
            <h2 class="text-2xl font-black text-slate-900 dark:text-white">
                انگ طلا چیست و چه اطلاعاتی روی قطعه طلای آبشده حک می‌شود؟
            </h2>
            <p class="text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed">
                هنگامی که طلاهای کارکرده و متفرقه در کوره ذوب می‌شوند، شمش آبشده حاصل ساختاری ناهمگن دارد. برای تعیین دقیق عیار، قطعه‌ای از آن قیچی شده (که به آن <em>تکه بار</em> می‌گویند) و به آزمایشگاه تخصصی <strong>ری گیری طلا</strong> فرستاده می‌شود. کارشناس ری‌گیری با روش کوپلاسیون، عیار دقیق را می‌سنجد و کدی منحصر‌به‌فرد روی شمش آبشده می‌کوبد که به آن <strong>انگ طلا</strong> گفته می‌شود.
            </p>
            <p class="text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed">
                روی هر قطعه آبشده معتبر اطلاعات زیر به صورت ضربی کوبیده می‌شود:
            </p>
            <ul class="list-disc list-inside space-y-2 text-sm text-slate-600 dark:text-slate-400 pr-2">
                <li><strong>نام ری‌گیری:</strong> نام آزمایشگاهی که نمونه را آزمون کرده است (مانند صفا، پارس، زرشناس).</li>
                <li><strong>شماره پاکت:</strong> شماره یکتا و سریال ثبت‌شده در دفتر کل آزمایشگاه ری‌گیری.</li>
                <li><strong>عیار خطی:</strong> عیار دقیق بر پایه ۱۰۰۰ (مانند ۷۳۵، ۷۴۰، ۷۵۰ یا ۷۶۵).</li>
            </ul>
        </div>

        {{-- جدول یونیک: اجزای کد انگ --}}
        <div class="space-y-4">
            <h3 class="text-lg font-black text-slate-900 dark:text-white">
                جدول اجزای کد انگ و ساختار شناسنامه طلای آبشده
            </h3>
            <div class="overflow-x-auto rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-lg">
                <table class="w-full text-right text-xs sm:text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-black border-b border-slate-200 dark:border-slate-800">
                        <tr>
                            <th class="p-4">بخش کد انگ</th>
                            <th class="p-4 text-amber-500">نمونه روی قطعه</th>
                            <th class="p-4">مفهوم و کاربرد صنفی</th>
                            <th class="p-4">مرجع استعلام</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <td class="p-4 font-bold">نام یا آرم ری‌گیری</td>
                            <td class="p-4 text-amber-600 dark:text-amber-400 font-bold">ری‌گیری تهران / صفا</td>
                            <td class="p-4 text-slate-500 dark:text-slate-400 text-xs">نشان‌دهنده آزمایشگاه دارای پروانه معتبر اتحادیه طلا و جواهر.</td>
                            <td class="p-4 text-slate-500 dark:text-slate-400 text-xs">فهرست آزمایشگاه‌های مجاز اتحادیه</td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <td class="p-4 font-bold">شماره پاکت (رسید)</td>
                            <td class="p-4 text-amber-600 dark:text-amber-400 font-bold">۱۴۵۸۹</td>
                            <td class="p-4 text-slate-500 dark:text-slate-400 text-xs">شناسه اختصاصی که در رایانه ری‌گیری و دفتر ثبت سوابق بایگانی شده است.</td>
                            <td class="p-4 text-slate-500 dark:text-slate-400 text-xs">سامانه پیامکی یا تلفنی همان ری‌گیری</td>
                        </tr>
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <td class="p-4 font-bold">عیار عیارسنجی‌شده</td>
                            <td class="p-4 text-emerald-600 dark:text-emerald-400 font-bold">۷۴۵ یا ۷۵۰</td>
                            <td class="p-4 text-slate-500 dark:text-slate-400 text-xs">خلوص طلا در هر ۱۰۰۰ واحد وزنی. اگر کمتر از ۷۵۰ باشد طلای شرطی و اگر بیشتر باشد پاداش عیار دارد.</td>
                            <td class="p-4 text-slate-500 dark:text-slate-400 text-xs">قبض رسمی و سامانه تلفن‌گویا</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- CTA میانی --}}
        @include('partials.cta-inline', [
            'title' => 'نمایش خودکار مظنه و نرخ طلای آبشده روی تلویزیون مغازه',
            'subtitle' => 'با تابلوی هوشمند طلالایو، مظنه تهران، نرخ آبشده نقدی و عیار ۱۸ را با اتصال مستقیم به تلویزیون ویترین بدون نیاز به مینی‌کیس به نمایش بگذارید.',
            'buttonText' => 'تست رایگان ۱۴ روزه تابلوی طلالایو',
            'buttonUrl' => route('admin.register'),
            'secondaryText' => 'محاسبه‌گر آنلاین طلای آبشده',
            'secondaryUrl' => route('public.tools.melted-gold'),
        ])

        {{-- بخش H2 دوم: مراحل گام‌به‌گام استعلام شماره پاکت --}}
        <div class="space-y-4">
            <h2 class="text-2xl font-black text-slate-900 dark:text-white">
                مراحل گام‌به‌گام استعلام شماره پاکت ری‌گیری و جواب انگ
            </h2>
            <p class="text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed">
                هنگامی که قطعه آبشده‌ای را خریداری می‌کنید یا به عنوان وثیقه و دادوستد تحویل می‌گیرید، برای استعلام <strong>جواب انگ</strong> مراحل زیر را انجام دهید:
            </p>
            <ol class="list-decimal list-inside space-y-3 text-sm text-slate-700 dark:text-slate-300 pr-2">
                <li>
                    <strong>شناسایی نام آزمایشگاه ری‌گیری:</strong> به نوشته یا مهر حروفی کوبیده‌شده روی شمش دقت کنید و نام آزمایشگاه را یادداشت کنید.
                </li>
                <li>
                    <strong>خواندن شماره پاکت:</strong> ارقام کوبیده‌شده در کنار نام ری‌گیری همان <strong>شماره پاکت</strong> هستند.
                </li>
                <li>
                    <strong>تماس با تلفن گویای ری‌گیری یا ارسال پیامک:</strong> اکثر آزمایشگاه‌های ری‌گیری عضو اتحادیه دارای سامانه گویا یا درگاه استعلام پیامکی هستند. شماره پاکت را وارد کنید تا سیستم عیار ثبت‌شده و وزن تحویلی را برایتان قرائت کند.
                </li>
                <li>
                    <strong>تطبیق جواب انگ با عدد کوبیده‌شده:</strong> عیاری که سامانه تلفنی یا پیامکی اعلام می‌کند باید عیناً با عیار حک‌شده روی قطعه و رسید کاغذی همخوانی داشته باشد.
                </li>
            </ol>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed pt-2">
                برای تبدیل عیار آبشده به وزن طلای استاندارد ۷۵۰ می‌توانید از ابزار تخصصی <a href="{{ route('public.tools.melted-gold') }}" class="text-amber-500 font-bold hover:underline">محاسبه‌گر طلای آبشده</a> و برای تبدیل واحدهای مختلف از <a href="{{ route('public.tools.karat-converter') }}" class="text-amber-500 font-bold hover:underline">تبدیل عیار طلا</a> استفاده نمایید.
            </p>
        </div>

        {{-- بخش H2 سوم: چه چیزهایی را نشان نمی‌دهد --}}
        <div class="space-y-4">
            <h2 class="text-2xl font-black text-slate-900 dark:text-white">
                کد انگ طلا چه مواردی را اثبات می‌کند و چه چیزهایی را نشان نمی‌دهد؟
            </h2>
            <p class="text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed">
                شناخت محدودیت‌های کد انگ برای پیشگیری از کلاهبرداری در صنف طلا حیاتی است:
            </p>
            <div class="grid sm:grid-cols-2 gap-4">
                <div class="p-5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/50 space-y-2">
                    <span class="text-emerald-600 dark:text-emerald-400 font-black text-sm">✅ مواردی که انگ اثبات می‌کند:</span>
                    <ul class="space-y-1.5 text-xs text-slate-600 dark:text-slate-400 list-disc list-inside">
                        <li>عیار علمی تکه نمونه‌برداری‌شده در تاریخ مشخص.</li>
                        <li>آزمون شدن توسط یک آزمایشگاه مشخص با شماره ثبتی معلوم.</li>
                        <li>عدم وجود مس یا ناخالصی بیش از حد استاندارد در قطعه آزمون‌شده.</li>
                    </ul>
                </div>

                <div class="p-5 rounded-2xl bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800/50 space-y-2">
                    <span class="text-rose-600 dark:text-rose-400 font-black text-sm">❌ مواردی که انگ اثبات نمی‌کند:</span>
                    <ul class="space-y-1.5 text-xs text-slate-600 dark:text-slate-400 list-disc list-inside">
                        <li>اصالت خود قالب؛ ممکن است انگ جعلی روی شمش تقلبی کوبیده شده باشد.</li>
                        <li>مغز شمش؛ اگر شمش دست‌ساز و ناهمگن باشد ممکن است مغز آن عیار متفاوتی داشته باشد.</li>
                        <li>مالکیت قانونی فرد؛ شمش آبشده شناسنامه هویتی مالک همراه ندارد.</li>
                    </ul>
                </div>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                به همین دلیل است که طلافروشان همواره شمش‌های آبشده مشکوک یا خریداری‌شده از افراد ناشناس را دوباره قیچی کرده و به ری‌گیری معتمد خود ارسال می‌کنند.
            </p>
        </div>

        {{-- بخش H2 چهارم: سامانه رسمی و لینک خروجی با TODO --}}
        <div class="space-y-4 p-6 rounded-3xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
            <h2 class="text-xl font-black text-slate-900 dark:text-white">
                سامانه رسمی استعلام و پیامک رهگیری ری‌گیری‌های کشور
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                اتحادیه طلا، جواهر، نقره و سکه تهران و سایر استان‌ها درگاه‌های رسمی جهت معرفی ری‌گیری‌های مجاز و استعلام پیامکی کدهای رهگیری راه‌اندازی نموده‌اند:
            </p>
            <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <span class="text-xs text-amber-500 font-bold">درگاه رسمی اتحادیه طلا و جواهر</span>
                    <div class="text-sm font-black text-slate-900 dark:text-white mt-0.5">سامانه جامع استعلام پروانه ری‌گیری‌ها و اعتبارسنجی</div>
                </div>
                <!-- TODO(data): آدرس سامانه رسمی -->
                <a href="https://estelam.ir" target="_blank" rel="nofollow noopener noreferrer" class="px-4 py-2 rounded-xl bg-slate-900 dark:bg-slate-700 text-white text-xs font-bold hover:bg-amber-500 hover:text-slate-950 transition-colors">
                    ورود به سامانه استعلام اتحادیه ←
                </a>
            </div>
            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                توجه: لینک فوق به درگاه رسمی صنفی هدایت می‌شود. برای تغییر یا به‌روزرسانی نشانی درگاه به فایل کانفیگ مراجعه نمایید.
            </p>
        </div>

        {{-- بلوک مطالب مرتبط --}}
        @include('partials.related-links', [
            'title' => 'ابزارها و راهنماهای مرتبط با معاملات طلای آبشده و عیار',
            'links' => [
                [
                    'title' => 'محاسبه‌گر تخصصی طلای آبشده',
                    'desc' => 'تبدیل وزن ترازوی آبشده و عیار انگ به وزن شرطی ۱۸ عیار و ارزش ریالی.',
                    'url' => route('public.tools.melted-gold'),
                ],
                [
                    'title' => 'تبدیل آنلاین عیار طلا',
                    'desc' => 'جدول و ابزار تبدیل انواع عیارهای ۷۵۰، ۷۰۵، ۷۴۰، ۹۰۰ و ۹۹۹ به یکدیگر.',
                    'url' => route('public.tools.karat-converter'),
                ],
                [
                    'title' => 'قیمت‌گذاری طلای دست دوم',
                    'desc' => 'محاسبه‌گر ارزش خرید طلای مستعمل پیش از ذوب و ارسال به ری‌گیری.',
                    'url' => route('public.tools.second-hand-gold'),
                ],
            ]
        ])

    </article>
</div>
@endsection
