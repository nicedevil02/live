@extends('layouts.public')

@section('title', 'سود قانونی طلافروشی چند درصد است؟ (۱۴۰۵) | طلالایو')
@section('meta_description', 'سود قانونی طلافروشی چند درصد است؟ تفکیک ۳ جزء فاکتور طلا (سود ۷٪، اجرت و مالیات)، فرمول محاسبه قانونی و بررسی مصوبه اتحادیه طلا. مطالعه کنید.')
@section('canonical', 'https://talalive.ir/guides/goldsmith-legal-profit')
@section('og_image', asset('images/guides/goldsmith-legal-profit.webp'))
@section('og_image_alt', 'سود قانونی طلافروشی چند درصد است و فاکتور طلا چگونه محاسبه می‌شود؟')

@section('schema')
@include('partials.schema-article', [
    'headline' => 'سود قانونی طلافروشی چند درصد است و فاکتور طلا چگونه محاسبه می‌شود؟',
    'description' => 'بررسی کامل مصوبه اتحادیه طلا درباره سود قانونی ۷ درصدی طلافروشان، نحوه تفکیک اجرت ساخت و مالیات بر ارزش افزوده در فاکتور رسمی.',
    'image' => 'https://talalive.ir/images/guides/goldsmith-legal-profit.webp',
    'datePublished' => '2026-03-25',
    'dateModified' => date('Y-m-d'),
    'author' => 'تیم حقوقی و قوانین صنفی طلالایو',
    'url' => 'https://talalive.ir/guides/goldsmith-legal-profit'
])
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">

    @include('partials.breadcrumb', [
        'items' => [
            ['title' => 'پایگاه دانش و مقالات', 'url' => route('public.guides')],
            ['title' => 'سود قانونی طلافروشی چند درصد است؟']
        ]
    ])

    <article class="space-y-8 bg-white dark:bg-slate-900/60 p-6 sm:p-10 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-xl shadow-slate-900/5">
        
        <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
            <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold">قوانین و مصوبات اتحادیه</span>
            <span>&bull;</span>
            <span>زمان مطالعه: حدود ۸ دقیقه</span>
            <span>&bull;</span>
            <span>تاریخ بازبینی: {{ date('Y/m/d') }}</span>
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            سود قانونی طلافروشی چند درصد است و فاکتور طلا چگونه محاسبه می‌شود؟
        </h1>

        {{-- تصویر شاخص راهنما با کیفیت عالی سئو و استانداردهای Core Web Vitals --}}
        <figure class="relative rounded-3xl overflow-hidden border border-amber-500/25 dark:border-slate-800 shadow-2xl aspect-[16/9] bg-slate-900 group">
            <img src="{{ asset('images/guides/goldsmith-legal-profit.webp') }}" 
                 alt="سود قانونی طلافروشی چند درصد است و فاکتور طلا چگونه محاسبه می‌شود؟" 
                 width="1200" height="675" 
                 loading="eager" fetchpriority="high" decoding="async"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.01]">
        </figure>

        {{-- تعریف صریح در ۴۰ کلمه اول --}}
        <div class="p-4 sm:p-5 rounded-2xl bg-amber-500/10 border-r-4 border-amber-500 text-slate-800 dark:text-slate-200 text-sm sm:text-base leading-relaxed font-medium">
            بر اساس مصوبه رسمی اتحادیه طلا و جواهر و سازمان حمایت از حقوق مصرف‌کنندگان، <strong>سود قانونی طلافروشی</strong> حداکثر <strong>۷ درصد</strong> است. این سود به حاصل‌جمع قیمت طلای خام و اجرت ساخت تعلق می‌گیرد و محاسبه هرگونه سود فراتر از آن تخلف صنفی محسوب می‌شود.
        </div>

        <div class="prose prose-slate dark:prose-invert max-w-none text-sm sm:text-base leading-relaxed text-slate-700 dark:text-slate-300 space-y-4">
            <p>
                در بازار طلا، شفافیت در صدور فاکتور مهم‌ترین ابزار جلب اعتماد خریداران است. بسیاری از مشتریان تفاوت میان سه جزء اصلی فاکتور یعنی <strong>اجرت و سود</strong> و مالیات را نمی‌دانند و تصور می‌کنند کل مبلغ افزوده شده به طلای خام سود خالص مغازه‌دار است.
            </p>
        </div>

        {{-- بخش H2 اول: تفکیک سه مفهوم --}}
        <div class="space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                تفکیک سه مفهوم بنیادین: اجرت ساخت، سود فروشنده و مالیات بر ارزش افزوده
            </h2>
            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                هر فاکتور رسمی طلافروشی از سه بخش مجزا از قیمت طلای خام تشکیل یافته است:
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/70 border border-slate-200 dark:border-slate-700/80 space-y-2">
                    <div class="text-amber-600 dark:text-amber-400 font-black text-base">۱. اجرت ساخت (کارمزد)</div>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        هزینه‌ای که کارگاه سازنده بابت طراحی، ریخته‌گری، مخراج‌کاری و تراشکاری دریافت می‌کند. این رقم بسته به پیچیدگی مصنوع بین ۴٪ تا ۳۵٪ یا به صورت مبلغ ثابت ریالی به ازای هر گرم است.
                    </p>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/70 border border-slate-200 dark:border-slate-700/80 space-y-2">
                    <div class="text-blue-600 dark:text-blue-400 font-black text-base">۲. سود قانونی فروشنده (۷٪)</div>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        حق‌العمل قانونی طلافروش بابت سرمایه‌گذاری، نگهداری ویترین، هزینه‌های جاری و بیمه مغازه است که طبق <strong>مصوبه اتحادیه</strong> حداکثر ۷ درصد روی مجموع طلا و اجرت محاسبه می‌گردد.
                    </p>
                </div>
                <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/70 border border-slate-200 dark:border-slate-700/80 space-y-2">
                    <div class="text-emerald-600 dark:text-emerald-400 font-black text-base">۳. مالیات بر ارزش افزوده (۹٪)</div>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        طبق قانون دائمی مالیات بر ارزش افزوده مصوب مجلس شورای اسلامی، اصل طلای خام از مالیات معاف است و مالیات ۹ درصدی تنها به «اجرت ساخت + سود طلافروش» تعلق می‌گیرد.
                    </p>
                </div>
            </div>
        </div>

        {{-- بخش H2 دوم: جدول اجزای فاکتور --}}
        <div class="space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                جدول تفکیکی اجزای فاکتور استاندارد طلافروشی
            </h2>
            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                ترتیب و شیوه استاندارد محاسبه اقلام فاکتور طلا به شرح جدول زیر است:
            </p>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800">
                <table class="w-full text-right text-xs sm:text-sm">
                    <thead class="bg-slate-100 dark:bg-slate-800/80 text-slate-900 dark:text-white font-bold">
                        <tr>
                            <th class="p-3.5 sm:p-4">ردیف</th>
                            <th class="p-3.5 sm:p-4">جزء فاکتور</th>
                            <th class="p-3.5 sm:p-4">مبنای محاسبه</th>
                            <th class="p-3.5 sm:p-4">درصد یا سقف مجاز</th>
                            <th class="p-3.5 sm:p-4">مرجع قانونی</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="p-3.5 sm:p-4">۱</td>
                            <td class="p-3.5 sm:p-4 font-bold">قیمت طلای خام</td>
                            <td class="p-3.5 sm:p-4">وزن قطعه × نرخ روز هر گرم طلای ۱۸ عیار</td>
                            <td class="p-3.5 sm:p-4">طبق مظنه رسمی روز</td>
                            <td class="p-3.5 sm:p-4 text-slate-500">بازار و اتحادیه طلا</td>
                        </tr>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="p-3.5 sm:p-4">۲</td>
                            <td class="p-3.5 sm:p-4 font-bold">اجرت ساخت</td>
                            <td class="p-3.5 sm:p-4">درصد از طلای خام یا مبلغ ثابت به ازای هر گرم</td>
                            <td class="p-3.5 sm:p-4">توافقی بسته به مدل مصنوع</td>
                            <td class="p-3.5 sm:p-4 text-slate-500">فاکتور بنکدار و کارگاه</td>
                        </tr>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="p-3.5 sm:p-4">۳</td>
                            <td class="p-3.5 sm:p-4 font-bold text-amber-600 dark:text-amber-400">درصد سود طلافروش</td>
                            <td class="p-3.5 sm:p-4">(قیمت طلای خام + اجرت ساخت) × ۷٪</td>
                            <td class="p-3.5 sm:p-4 font-black">حداکثر ۷ درصد</td>
                            <td class="p-3.5 sm:p-4 text-slate-500">مصوبه کمیسیون نظارت</td>
                        </tr>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="p-3.5 sm:p-4">۴</td>
                            <td class="p-3.5 sm:p-4 font-bold text-emerald-600 dark:text-emerald-400">مالیات ارزش افزوده</td>
                            <td class="p-3.5 sm:p-4">(اجرت ساخت + سود طلافروش) × ۹٪</td>
                            <td class="p-3.5 sm:p-4 font-black">۹ درصد (معافیت اصل طلا)</td>
                            <td class="p-3.5 sm:p-4 text-slate-500">قانون مالیات مودیان</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- بخش H2 سوم: فرمول کامل با مثال عددی --}}
        <div class="space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                فرمول کامل و قانونی محاسبه قیمت طلا با مثال عددی شفاف
            </h2>
            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                فرمول جامع فاکتور استاندارد طلا به شرح زیر بیان می‌شود:
            </p>

            <div class="p-5 rounded-2xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 font-mono text-xs sm:text-sm text-slate-900 dark:text-slate-100 leading-loose text-left" dir="ltr">
                قیمت کل = [وزن × نرخ ۱۸ عیار] + اجرت ساخت + سود ۷٪ + مالیات ۹٪ اجرت و سود
            </div>

            <div class="p-6 rounded-3xl bg-emerald-500/10 border border-emerald-500/30 space-y-3 text-sm text-slate-800 dark:text-slate-200">
                <div class="font-bold text-emerald-700 dark:text-emerald-400 text-base">مثال محاسباتی گام‌به‌گام (فاکتور نمونه):</div>
                <p>فرض کنید یک النگو با مشخصات زیر خریداری می‌شود:</p>
                <ul class="list-disc list-inside space-y-1 font-mono text-xs sm:text-sm">
                    <li>وزن النگو: ۵.۰۰ گرم</li>
                    <li>نرخ هر گرم طلای ۱۸ عیار خام: ۵,۰۰۰,۰۰۰ تومان</li>
                    <li>درصد اجرت ساخت: ۱۰٪ (معادل ۵۰۰,۰۰۰ تومان به ازای هر گرم)</li>
                </ul>
                <div class="pt-2 border-t border-emerald-500/20 space-y-1 text-xs sm:text-sm">
                    <p>۱. قیمت طلای خام: ۵ × ۵,۰۰۰,۰۰۰ = <strong>۲۵,۰۰۰,۰۰۰ تومان</strong></p>
                    <p>۲. مبلغ کل اجرت: ۵ × ۵۰۰,۰۰۰ = <strong>۲,۵۰۰,۰۰۰ تومان</strong></p>
                    <p>۳. سود قانونی طلافروش (۷٪): (۲۵,۰۰۰,۰۰۰ + ۲,۵۰۰,۰۰۰) × ۷٪ = <strong>۱,۹۲۵,۰۰۰ تومان</strong></p>
                    <p>۴. مالیات ارزش افزوده (۹٪): (۲,۵۰۰,۰۰۰ + ۱,۹۲۵,۰۰۰) × ۹٪ = <strong>۳۹۸,۲۵۰ تومان</strong></p>
                    <div class="pt-2 text-base font-black text-emerald-800 dark:text-emerald-300">
                        مبلغ نهایی پرداختی مشتری: ۲۹,۸۲۳,۲۵۰ تومان
                    </div>
                </div>
            </div>

            <p class="text-xs text-slate-500 dark:text-slate-400">
                برای انجام فوری این محاسبات بدون نیاز به ماشین‌حساب دستی، از <a href="{{ route('public.tools.gold-price') }}" class="text-amber-600 dark:text-amber-400 underline font-bold">ماشین‌حساب قیمت طلا با اجرت و مالیات</a> و همچنین <a href="{{ route('public.tools.wage-calculator') }}" class="text-amber-600 dark:text-amber-400 underline font-bold">محاسبه‌گر اجرت ساخت</a> استفاده نمایید.
            </p>
        </div>

        {{-- CTA میانی --}}
        @include('partials.cta-inline', [
            'title' => 'فرمول‌ساز خودکار سود و اجرت در تابلوی هوشمند طلالایو',
            'subtitle' => 'تنظیم آسان درصد سود فروش و حاشیه خرید برای هر ویترین از طریق پنل مدیریت ابری طلالایو با نمایش زنده روی تلویزیون مغازه.',
            'buttonText' => 'تست رایگان ۱۴ روزه تابلوی طلالایو',
            'buttonUrl' => route('admin.register'),
            'secondaryText' => 'مشاهده دموی سامانه',
            'secondaryUrl' => url('/demo')
        ])

        {{-- بخش H2 چهارم: مرجع قانونی و مصوبه اتحادیه --}}
        <div class="space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                مرجع قانونی و مصوبه رسمی اتحادیه طلا و جواهر
            </h2>
            <p class="text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed">
                سقف سود مجاز ۷ درصدی توسط کمیسیون نظارت بر سازمان‌های صنفی و اتحادیه طلا و جواهر تعیین شده است و بازرسان اصناف با بررسی فاکتورهای صادره بر رعایت این نرخ نظارت می‌کنند. همچنین قوانین ثبت فاکتور الکترونیک در سامانه جامع تجارت و پایانه فروشگاهی بر مبنای همین فرمول نظارت‌پذیر شده است.
            </p>
            <div class="p-4 rounded-2xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-500 dark:text-slate-400">
                <span class="font-bold text-slate-700 dark:text-slate-300">منبع استناد رسمی:</span> 
                دستورالعمل نظارت بر فاکتور طلا و مسکوکات مصوب کمیسیون نظارت بر سازمان‌های صنفی کشور. <!-- TODO(data): لینک مصوبه رسمی -->
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                برای مطالعه تکالیف قانونی طلافروشان در سامانه مودیان به راهنمای <a href="{{ route('public.guides.show', 'gold-tax-regulations') }}" class="text-amber-600 dark:text-amber-400 underline font-bold">قانون جدید مالیات طلا و اجرت</a> مراجعه فرمایید.
            </p>
        </div>

        {{-- بلوک مطالب مرتبط --}}
        @include('partials.related-links', [
            'title' => 'ابزارها و راهنماهای مرتبط با محاسبات فاکتور طلا',
            'links' => [
                [
                    'title' => 'ماشین‌حساب قیمت طلا با اجرت و مالیات',
                    'url' => route('public.tools.gold-price'),
                    'desc' => 'محاسبه آنی فاکتور خرید طلا با درصد سود قانونی ۷٪ و مالیات ۹ درصدی.'
                ],
                [
                    'title' => 'قانون جدید مالیات طلا در سامانه مودیان',
                    'url' => route('public.guides.show', 'gold-tax-regulations'),
                    'desc' => 'تکالیف قانونی ثبت پایانه فروشگاهی و نحوه اعمال معافیت اصل طلا.'
                ],
                [
                    'title' => 'ماشین‌حساب درصد اجرت ساخت طلا',
                    'url' => route('public.tools.wage-calculator'),
                    'desc' => 'جدول و ابزار محاسبه درصدهای مختلف اجرت طلا از صفر تا ۳۰ درصد.'
                ]
            ]
        ])

    </article>
</div>
@endsection
