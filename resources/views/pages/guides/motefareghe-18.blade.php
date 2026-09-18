@extends('layouts.public')

@section('title', 'تعویض و خرید متفرقه ۱۸ چیست؟ راهنمای طلافروش | طلالایو')
@section('meta_description', 'تعویض و خرید متفرقه ۱۸ چیست؟ تفاوت ۲ نرخ طلای متفرقه، نمونه فاکتور تعویض با برچسب مثال و نحوه نمایش در تابلوی طلالایو. مطالعه کنید.')
@section('canonical', 'https://talalive.ir/guides/motefareghe-18')
@section('og_image', asset('images/guides/motefareghe-18.webp'))
@section('og_image_alt', 'تعویض و خرید متفرقه ۱۸ چیست و چگونه محاسبه می‌شود؟')

@section('schema')
@include('partials.schema-article', [
    'headline' => 'تعویض متفرقه ۱۸ چیست و چه فرقی با خرید متفرقه طلا دارد؟',
    'description' => 'راهنمای جامع تعویض و خرید متفرقه ۱۸ عیار در بازار طلا، مقایسه حاشیه سود و نمونه فاکتور محاسبه برای طلافروشان.',
    'image' => 'https://talalive.ir/images/guides/motefareghe-18.webp',
    'datePublished' => '2026-03-22',
    'dateModified' => date('Y-m-d'),
    'author' => 'تیم تحریریه و محاسبات صنفی طلالایو',
    'url' => 'https://talalive.ir/guides/motefareghe-18'
])
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">

    @include('partials.breadcrumb', [
        'items' => [
            ['title' => 'پایگاه دانش و مقالات', 'url' => route('public.guides')],
            ['title' => 'تعویض و خرید متفرقه ۱۸ چیست؟']
        ]
    ])

    <article class="space-y-8 bg-white dark:bg-slate-900/60 p-6 sm:p-10 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-xl shadow-slate-900/5">
        
        <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
            <span class="px-3 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold">حسابداری و فاکتور طلا</span>
            <span>&bull;</span>
            <span>زمان مطالعه: حدود ۷ دقیقه</span>
            <span>&bull;</span>
            <span>تاریخ بازبینی: {{ date('Y/m/d') }}</span>
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            تعویض متفرقه ۱۸ چیست و چه تفاوتی با خرید متفرقه دارد؟
        </h1>

        {{-- تصویر شاخص راهنما با کیفیت عالی سئو و استانداردهای Core Web Vitals --}}
        <figure class="relative rounded-3xl overflow-hidden border border-amber-500/25 dark:border-slate-800 shadow-2xl aspect-[16/9] bg-slate-900 group">
            <img src="{{ asset('images/guides/motefareghe-18.webp') }}" 
                 alt="تعویض متفرقه ۱۸ چیست و چه تفاوتی با خرید متفرقه دارد؟" 
                 width="1200" height="675" 
                 loading="eager" fetchpriority="high" decoding="async"
                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.01]">
        </figure>

        {{-- تعریف صریح در ۴۰ کلمه اول --}}
        <div class="p-4 sm:p-5 rounded-2xl bg-amber-500/10 border-r-4 border-amber-500 text-slate-800 dark:text-slate-200 text-sm sm:text-base leading-relaxed font-medium">
            در صنف طلا و جواهر، <strong>طلای متفرقه</strong> به هر نوع مصنوعات طلای مستعمل و بدون فاکتور ساخت گفته می‌شود که مشتری قصد فروش یا تبدیل آن را دارد. <strong>تعویض متفرقه ۱۸</strong> دریافت طلای کهنه مشتری در ازای طلای نو با کسر کارمزد کمتر در مقایسه با نرخ <strong>خرید متفرقه ۱۸</strong> نقدی است.
        </div>

        <div class="prose prose-slate dark:prose-invert max-w-none text-sm sm:text-base leading-relaxed text-slate-700 dark:text-slate-300 space-y-4">
            <p>
                یکی از پرسش‌های متداول مشتریان و طلافروشان تازه‌کار این است که <strong>متفرقه چیست</strong> و چرا در تابلوی نرخ مغازه‌ها دو ردیف جداگانه برای «خرید متفرقه» و «تعویض متفرقه» درج می‌گردد. پاسخ در تفاوت حاشیه ریسک نقدشوندگی و گردش طلای کارگاه نهفته است.
            </p>
        </div>

        {{-- بخش H2 اول: جدول مقایسه --}}
        <div class="space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                تفاوت بنیادین خرید متفرقه ۱۸ و تعویض متفرقه ۱۸
            </h2>
            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                این دو عملیات در حسابداری طلافروشی اثرات نقدی و وزنی کاملاً متفاوتی دارند:
            </p>

            <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800">
                <table class="w-full text-right text-xs sm:text-sm">
                    <thead class="bg-slate-100 dark:bg-slate-800/80 text-slate-900 dark:text-white font-bold">
                        <tr>
                            <th class="p-3.5 sm:p-4">شاخص مقایسه</th>
                            <th class="p-3.5 sm:p-4">خرید متفرقه ۱۸ (نقدی)</th>
                            <th class="p-3.5 sm:p-4">تعویض متفرقه ۱۸ (تبدیل به نو)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="p-3.5 sm:p-4 font-bold text-slate-900 dark:text-white">جریان نقدینگی</td>
                            <td class="p-3.5 sm:p-4 text-rose-600 dark:text-rose-400">خروج وجه نقد از حساب فروشگاه به حساب مشتری</td>
                            <td class="p-3.5 sm:p-4 text-emerald-600 dark:text-emerald-400">جابه‌جایی وزنی طلا و دریافت مابه‌التفاوت اجرت و سود</td>
                        </tr>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="p-3.5 sm:p-4 font-bold text-slate-900 dark:text-white">نرخ خرید هر گرم</td>
                            <td class="p-3.5 sm:p-4">معمولاً با کسر درصدی مشخص (حدود ۱ تا ۲ درصد) از قیمت خام ۱۸ عیار</td>
                            <td class="p-3.5 sm:p-4 font-semibold text-amber-600 dark:text-amber-400">نزدیک‌تر به نرخ خام روز (کسر کمتر یا بدون کسر)</td>
                        </tr>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="p-3.5 sm:p-4 font-bold text-slate-900 dark:text-white">مزیت برای مشتری</td>
                            <td class="p-3.5 sm:p-4">دریافت سریع وجه ریالی در کارت بانکی</td>
                            <td class="p-3.5 sm:p-4">ارزش‌گذاری بالاتر طلای قدیمی و کاهش هزینه خرید طلای نو</td>
                        </tr>
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40">
                            <td class="p-3.5 sm:p-4 font-bold text-slate-900 dark:text-white">مقصد طلای دریافتی</td>
                            <td class="p-3.5 sm:p-4">ارسال به کارگاه ری‌گیری جهت تبدیل به <a href="{{ route('public.tools.melted-gold') }}" class="text-amber-600 dark:text-amber-400 underline font-bold">طلای آبشده</a></td>
                            <td class="p-3.5 sm:p-4">وزن‌کشی در تراز کارگاهی و تسویه با بنکدار سازنده</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- بخش H2 دوم: مثال فاکتور نمونه --}}
        <div class="space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                نمونه فاکتور تعویض طلای متفرقه ۱۸ با طلای نو (محاسبه گام‌به‌گام)
            </h2>
            <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                برای درک بهتر شیوه فاکتورنویسی، به این سناریوی فرضی توجه فرمایید:
            </p>

            <div class="p-6 rounded-3xl bg-slate-50 dark:bg-slate-800/70 border border-slate-200 dark:border-slate-700/80 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-3">
                    <span class="text-xs font-black text-amber-600 dark:text-amber-400 uppercase tracking-wider">برچسب: مثال فاکتور فرضی تعویض</span>
                    <span class="text-xs text-slate-500">نرخ خام مبنا: ۶,۰۰۰,۰۰۰ تومان</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs sm:text-sm">
                    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                        <div class="font-bold text-slate-900 dark:text-white mb-2">۱. طلای متفرقه دریافتی از مشتری:</div>
                        <div class="flex justify-between"><span>وزن طلای کهنه:</span><span class="font-mono font-bold">۱۰.۰۰ گرم</span></div>
                        <div class="flex justify-between"><span>نرخ تعویض متفرقه ۱۸:</span><span class="font-mono">۵,۹۵۰,۰۰۰ تومان</span></div>
                        <div class="flex justify-between pt-2 border-t border-slate-100 dark:border-slate-800 text-amber-600 dark:text-amber-400 font-bold">
                            <span>ارزش طلای مشتری:</span><span>۵۹,۵۰۰,۰۰۰ تومان</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-2">
                        <div class="font-bold text-slate-900 dark:text-white mb-2">۲. طلای نو انتخابی از ویترین:</div>
                        <div class="flex justify-between"><span>وزن طلای نو:</span><span class="font-mono font-bold">۱۰.۰۰ گرم</span></div>
                        <div class="flex justify-between"><span>نرخ خام روز:</span><span class="font-mono">۶,۰۰۰,۰۰۰ تومان</span></div>
                        <div class="flex justify-between"><span>اجرت ساخت و سود:</span><span class="font-mono">۱۸٪ (۱,۰۸۰,۰۰۰ تومان/گرم)</span></div>
                        <div class="flex justify-between pt-2 border-t border-slate-100 dark:border-slate-800 text-blue-600 dark:text-blue-400 font-bold">
                            <span>قیمت کل طلای نو:</span><span>۷۰,۸۰۰,۰۰۰ تومان</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-between text-sm sm:text-base font-black text-slate-900 dark:text-white">
                    <span>مبلغ نهایی قابل پرداخت توسط مشتری:</span>
                    <span class="text-amber-600 dark:text-amber-400 font-mono">۱۱,۳۰۰,۰۰۰ تومان</span>
                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    برای محاسبه دقیق درصد سود مجاز و مالیات بر اجرت طبق بخشنامه اتحادیه، به راهنمای <a href="{{ route('public.guides.show', 'goldsmith-legal-profit') }}" class="text-amber-600 dark:text-amber-400 underline font-bold">سود قانونی طلافروشی</a> مراجعه فرمایید.
                </p>
            </div>
        </div>

        {{-- CTA میانی --}}
        @include('partials.cta-inline', [
            'title' => 'نمایش دقیق نرخ تعویض و خرید متفرقه روی نرخ‌نامه دیجیتال',
            'subtitle' => 'با تابلوی هوشمند طلالایو، می‌توانید ردیف‌های اختصاصی تعویض و خرید متفرقه ۱۸ را بر اساس درصد دلخواه در تابلوی تلویزیون ویترین فعال کنید.',
            'buttonText' => 'راه‌اندازی نرخ‌نامه دیجیتال',
            'buttonUrl' => url('/digital-rate-board'),
            'secondaryText' => 'تست رایگان ۱۴ روزه',
            'secondaryUrl' => route('admin.register')
        ])

        {{-- بخش H2 سوم: نمایش این دو نرخ در تابلوی مغازه --}}
        <div class="space-y-4">
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                این دو نرخ در تابلوی مغازه چطور باید نمایش داده شود؟
            </h2>
            <p class="text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed">
                در گذشته روی تابلوهای ۷ رقمه ال ای دی سنتی به دلیل محدودیت تعداد ردیف‌ها، تنها نرخ فروش طلای ۱۸ عیار و مظنه نمایش داده می‌شد. طلافروش ناچار بود نرخ خرید طلای کهنه را شفاهاً یا روی برگه کاغذ اعلام کند که موجب بی‌اعتمادی مشتریان می‌شد.
            </p>
            <p class="text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed">
                در سامانه مدرن <a href="{{ url('/digital-rate-board') }}" class="text-amber-600 dark:text-amber-400 underline font-bold">نرخ‌نامه دیجیتال طلافروشی</a> طلالایو:
            </p>
            <ul class="list-disc list-inside space-y-2 text-sm text-slate-600 dark:text-slate-400 pr-2">
                <li><strong>ردیف مستقل خرید متفرقه ۱۸:</strong> به‌صورت خودکار بر مبنای حاشیه امن تعیین‌شده توسط گالری‌دار از نرخ خام محاسبه و نمایش می‌یابد.</li>
                <li><strong>ردیف تعویض متفرقه ۱۸:</strong> برای تشویق مراجعین به نوسازی طلاهای قدیمی با شفافیت کامل روی تلویزیون ویترین درج می‌شود.</li>
                <li><strong>تغییر آنی با گوشی:</strong> در صورت نوسان شدید بازار، درصد کسر متفرقه ظرف چند ثانیه از پنل موبایل بروزرسانی می‌شود.</li>
            </ul>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-3 leading-relaxed">
                همچنین برای محاسبه آنلاین ارزش تسویه طلای کارکرده با کسر افت و نگین می‌توانید از ابزار تخصصی <a href="{{ route('public.tools.second-hand-gold') }}" class="text-amber-600 dark:text-amber-400 underline font-bold">قیمت‌گذاری طلای دست دوم</a> استفاده کنید.
            </p>
        </div>

        {{-- بلوک مطالب مرتبط --}}
        @include('partials.related-links', [
            'title' => 'راهنماها و ابزارهای مرتبط با طلای متفرقه و آبشده',
            'links' => [
                [
                    'title' => 'محاسبه‌گر تخصصی طلای آبشده',
                    'url' => route('public.tools.melted-gold'),
                    'desc' => 'تبدیل طلای متفرقه و شرطی به وزن خطی با عیار استاندارد ۷۵۰.'
                ],
                [
                    'title' => 'سود قانونی طلافروشی چقدر است؟',
                    'url' => route('public.guides.show', 'goldsmith-legal-profit'),
                    'desc' => 'بررسی درصد سود مصوب اتحادیه و تفکیک اجرت ساخت از مالیات.'
                ],
                [
                    'title' => 'نرخ‌نامه دیجیتال طلافروشی',
                    'url' => url('/digital-rate-board'),
                    'desc' => 'جایگزین تابلوی ۷ رقمه سنتی بدون نیاز به سخت‌افزار با قابلیت تفکیک نرخ‌ها.'
                ]
            ]
        ])

    </article>
</div>
@endsection
