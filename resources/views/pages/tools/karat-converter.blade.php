@extends('layouts.public')

@section('title', 'ماشین حساب تبدیل عیار طلا آنلاین (۷۵۰ به ۷۰۵، ۷۴۰، ۹۹۹) | جدول عیار طلا و نقره | طلالایو')
@section('meta_description', 'ابزار آنلاین تبدیل انواع عیارهای طلا و نقره: تبدیل عیار ۷۰۵، ۷۴۰، ۷۵۰، ۹۹۹ و عیارهای نقره ۹۲۵ و ۹۹۵ به همراه جدول کامل ضرایب خلوص اتحادیه طلا و جواهر.')
@section('canonical', 'https://talalive.ir/tools/karat-converter')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "ابزار و ماشین حساب تبدیل عیار طلا و نقره",
      "alternateName": [
        "ماشین حساب تبدیل عیار",
        "تبدیل عیار طلا",
        "جدول عیار طلا",
        "تبدیل عیار ۷۵۰ به ۷۰۵",
        "عیار نقره ۹۲۵ و ۹۹۵"
      ],
      "url": "https://talalive.ir/tools/karat-converter",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار آنلاین محاسبه و تبدیل انواع عیارهای رسمی، متفرقه و شمش طلا و نقره با جدول مرجع استاندارد."
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
          "name": "ابزارها",
          "item": "https://talalive.ir/gold-calculator"
        },
        {
          "@@type": "ListItem",
          "position": 3,
          "name": "تبدیل عیار طلا",
          "item": "https://talalive.ir/tools/karat-converter"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-12">

    {{-- هدر صفحه --}}
    <div class="text-center space-y-4 max-w-2xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-bold">
            <span>استاندارد عیارسنجی ری‌گیری و خلوص در هزار • سال ۱۴۰۵</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            ماشین حساب تبدیل عیار طلا و نقره <br>
            <span class="text-amber-500">تبدیل عیار مبدأ به مقصد با جدول استاندارد</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm">
            محاسبه آنی وزن معادل برای انواع عیارهای ۷۰۵، ۷۴۰، ۷۵۰، ۹۹۹ و عیارهای نقره ۹۲۵ و ۹۹۵
        </p>
    </div>

    {{-- ویجت آلپاین تبدیل عیار --}}
    <div x-data="{
        weight: 10,
        sourceKarat: 750,
        targetKarat: 999.9,
        get convertedWeight() {
            const w = parseFloat(this.weight) || 0;
            const sk = parseFloat(this.sourceKarat) || 750;
            const tk = parseFloat(this.targetKarat) || 999.9;
            if (tk <= 0) return 0;
            return parseFloat(((w * sk) / tk).toFixed(3));
        }
    }" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 items-center">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">وزن فلز مبدأ (گرم):</label>
                <input type="number" step="0.01" min="0.01" x-model.number="weight" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">عیار اولیه (مبدأ):</label>
                <select x-model.number="sourceKarat" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-sm focus:outline-none focus:border-amber-500">
                    <optgroup label="طلا (خلوص در ۱۰۰۰)">
                        <option value="750">۱۸ عیار استاندارد رسمی (۷۵۰)</option>
                        <option value="740">طلای متفرقه سبک کارگاهی (۷۴۰)</option>
                        <option value="705">۱۷ عیار / مبنای مظنه مثقال (۷۰۵)</option>
                        <option value="900">۲۱.۶ عیار مسکوکات بهار آزادی (۹۰۰)</option>
                        <option value="875">۲۱ عیار خلیجی و عربی (۸۷۵)</option>
                        <option value="999.9">۲۴ عیار خالص / شمش طلا (۹۹۹.۹)</option>
                    </optgroup>
                    <optgroup label="نقره (خلوص در ۱۰۰۰)">
                        <option value="925">نقره استرلینگ زیورآلات (۹۲۵)</option>
                        <option value="995">نقره شمش و ساچمه کارگاهی (۹۹۵)</option>
                    </optgroup>
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">عیار مورد نظر (مقصد):</label>
                <select x-model.number="targetKarat" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-sm focus:outline-none focus:border-amber-500">
                    <optgroup label="طلا (خلوص در ۱۰۰۰)">
                        <option value="999.9">۲۴ عیار خالص / شمش طلا (۹۹۹.۹)</option>
                        <option value="750">۱۸ عیار استاندارد رسمی (۷۵۰)</option>
                        <option value="740">طلای متفرقه سبک کارگاهی (۷۴۰)</option>
                        <option value="705">۱۷ عیار / مبنای مظنه مثقال (۷۰۵)</option>
                        <option value="900">۲۱.۶ عیار مسکوکات بهار آزادی (۹۰۰)</option>
                        <option value="875">۲۱ عیار خلیجی و عربی (۸۷۵)</option>
                    </optgroup>
                    <optgroup label="نقره (خلوص در ۱۰۰۰)">
                        <option value="925">نقره استرلینگ زیورآلات (۹۲۵)</option>
                        <option value="995">نقره شمش و ساچمه کارگاهی (۹۹۵)</option>
                    </optgroup>
                </select>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-amber-500/10 border border-amber-500/30 text-center space-y-2">
            <span class="text-xs font-bold text-amber-700 dark:text-amber-300">وزن معادل دقیق در عیار مقصد:</span>
            <div class="text-3xl sm:text-4xl font-black text-amber-500">
                <span x-text="convertedWeight.toLocaleString('fa-IR')"></span> گرم
            </div>
            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                فرمول: <code>وزن مقصد = (وزن مبدأ × عیار مبدأ) ÷ عیار مقصد</code>
            </p>
        </div>
    </div>

    {{-- جدول کامل تبدیل عیار شامل ۷۰۵، ۷۴۰، ۷۵۰، ۹۹۹ و عیارهای نقره ۹۲۵ و ۹۹۵ --}}
    <section class="space-y-6">
        <div class="text-center space-y-3">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                جدول جامع تبدیل عیار طلا و نقره در صنف طلا و جواهر
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm max-w-3xl mx-auto">
                راهنمای استاندارد عیارهای رسمی، نام‌گذاری سنتی، میزان خلوص بر پایه ۱۰۰۰ و کاربرد صنعتی هر عیار در بازار ایران:
            </p>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xl">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-black border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="p-4 sm:p-5">عیار عددی (در هزار)</th>
                        <th class="p-4 sm:p-5 text-amber-500">معادل سنتی (در ۲۴)</th>
                        <th class="p-4 sm:p-5">درصد خلوص فلز خالص</th>
                        <th class="p-4 sm:p-5">کاربرد اصلی در صنف</th>
                        <th class="p-4 sm:p-5">ضریب تبدیل به ۱۸ عیار</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                        <td class="p-4 sm:p-5 font-black text-amber-600 dark:text-amber-400">۷۰۵</td>
                        <td class="p-4 sm:p-5 font-bold">۱۷ عیار (مظنه)</td>
                        <td class="p-4 sm:p-5 font-mono">۷۰.۵٪</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">مبنای سنتی یک مثقال مظنه بازار بزرگ تهران و طلای قدیمی یزد.</td>
                        <td class="p-4 sm:p-5 font-mono font-bold">۰.۹۴۰۰</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                        <td class="p-4 sm:p-5 font-black text-amber-600 dark:text-amber-400">۷۴۰</td>
                        <td class="p-4 sm:p-5 font-bold">۱۷.۷۶ عیار</td>
                        <td class="p-4 sm:p-5 font-mono">۷۴.۰٪</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">طلای متفرقه دست دوم سبک و النگوهای شکسته با لحیم زیاد.</td>
                        <td class="p-4 sm:p-5 font-mono font-bold">۰.۹۸۶۶</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 bg-amber-500/5">
                        <td class="p-4 sm:p-5 font-black text-amber-600 dark:text-amber-400">۷۵۰</td>
                        <td class="p-4 sm:p-5 font-bold">۱۸ عیار استاندارد</td>
                        <td class="p-4 sm:p-5 font-mono">۷۵.۰٪</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">استاندارد رسمی کلیه مصنوعات قانونی ویترین طلافروشی‌های کشور.</td>
                        <td class="p-4 sm:p-5 font-mono font-bold text-emerald-600 dark:text-emerald-400">۱.۰۰۰۰</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                        <td class="p-4 sm:p-5 font-black text-amber-600 dark:text-amber-400">۸۷۵</td>
                        <td class="p-4 sm:p-5 font-bold">۲۱ عیار خلیجی</td>
                        <td class="p-4 sm:p-5 font-mono">۸۷.۵٪</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">طلاهای وارداتی و سفارشی کشورهای عربی حوزه خلیج فارس.</td>
                        <td class="p-4 sm:p-5 font-mono font-bold">۱.۱۶۶۶</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                        <td class="p-4 sm:p-5 font-black text-amber-600 dark:text-amber-400">۹۰۰</td>
                        <td class="p-4 sm:p-5 font-bold">۲۱.۶ عیار بانکی</td>
                        <td class="p-4 sm:p-5 font-mono">۹۰.۰٪</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">عیار مصوب کلیه مسکوکات ضرب بانک مرکزی (امامی، بهار آزادی، نیم و ربع).</td>
                        <td class="p-4 sm:p-5 font-mono font-bold">۱.۲۰۰۰</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                        <td class="p-4 sm:p-5 font-black text-amber-600 dark:text-amber-400">۹۹۹ یا ۹۹۹.۹</td>
                        <td class="p-4 sm:p-5 font-bold">۲۴ عیار خالص</td>
                        <td class="p-4 sm:p-5 font-mono">۹۹.۹٪</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">شمش‌های استاندارد بین‌المللی و طلای خالص بانک کارگشایی.</td>
                        <td class="p-4 sm:p-5 font-mono font-bold">۱.۳۳۳۲</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 bg-slate-50/80 dark:bg-slate-800/50">
                        <td class="p-4 sm:p-5 font-black text-cyan-600 dark:text-cyan-400">۹۲۵ (نقره)</td>
                        <td class="p-4 sm:p-5 font-bold">نقره استرلینگ</td>
                        <td class="p-4 sm:p-5 font-mono">۹۲.۵٪</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">عیار قانونی و رسمی ساخت انواع زیورآلات، ظروف و انگشتر نقره.</td>
                        <td class="p-4 sm:p-5 font-mono text-slate-400">-</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 bg-slate-50/80 dark:bg-slate-800/50">
                        <td class="p-4 sm:p-5 font-black text-cyan-600 dark:text-cyan-400">۹۹۵ (نقره)</td>
                        <td class="p-4 sm:p-5 font-bold">نقره خالص کارگاهی</td>
                        <td class="p-4 sm:p-5 font-mono">۹۹.۵٪</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">نقره ساچمه و شمش خام کارگاه‌های نقره‌سازی و آبکاری.</td>
                        <td class="p-4 sm:p-5 font-mono text-slate-400">-</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 text-xs text-slate-700 dark:text-slate-300 flex flex-col sm:flex-row items-center justify-between gap-3 mt-4">
            <span>آیا فروشگاه نقره یا کارگاه ساچمه دارید؟ قیمت لحظه‌ای انواع عیار نقره و شمش را روی تلویزیون نمایش دهید:</span>
            <a href="/silver-bullion-board" class="whitespace-nowrap px-4 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-700 text-white font-bold transition-colors">
                تابلو نرخ نقره و شمش ←
            </a>
        </div>
    </section>

    {{-- بنر فراخوان میانی --}}
    @include('partials.cta-inline', [
        'title' => 'تابلوی هوشمند طلالایو؛ نمایش خودکار عیارهای ۱۸، سکه و انس جهانی',
        'subtitle' => 'دیگر نیازی به تبدیل دستی عیار برای مراجعین ندارید. سامانه ابری طلالایو تمام نرخ‌های صنفی را روی تلویزیون مغازه به‌صورت زنده به نمایش می‌گذارد.',
        'buttonText' => 'تست رایگان ۱۴ روزه تابلوی طلالایو',
        'buttonUrl' => route('admin.register'),
        'secondaryText' => 'راهنمای استعلام انگ طلا',
        'secondaryUrl' => route('public.guides.show', 'gold-hallmark-inquiry'),
    ])

    {{-- توضیحات آموزشی و کاربردها --}}
    <section class="grid sm:grid-cols-2 gap-6">
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-md">
            <h3 class="text-base font-black text-slate-900 dark:text-white">
                تبدیل عیار طلای آبشده در ری‌گیری
            </h3>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                هنگامی که شمش آبشده را از کوره ری‌گیری تحویل می‌گیرید، معمولاً عیار آن دقیقاً ۷۵۰ نیست (مثلاً ۷۳۵ یا ۷۶۰ است). در بازار طلا وزن ترازوی قطعه را با ضریب <code>عیار انگ ÷ ۷۵۰</code> به «وزن شرطی معادل ۱۸ عیار» تبدیل می‌کنند. برای انجام خودکار این محاسبه می‌توانید از <a href="{{ route('public.tools.melted-gold') }}" class="text-amber-500 font-bold hover:underline">محاسبه‌گر طلای آبشده</a> استفاده نمایید.
            </p>
        </div>

        <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-md">
            <h3 class="text-base font-black text-slate-900 dark:text-white">
                تأثیر عیار در قیمت‌گذاری طلای دست دوم
            </h3>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                طلاهای کارکرده و شکسته قدیمی معمولاً عیار واقعی ۷۴۰ دارند نه ۷۵۰، زیرا در ساخت آنها لحیم نقره یا مس به کار رفته است. طلافروش با عیارسنجی دقیق و کسر افت، ارزش خرید منصفانه را محاسبه می‌کند. برای مشاهده فرمول کامل به ابزار <a href="{{ route('public.tools.second-hand-gold') }}" class="text-amber-500 font-bold hover:underline">قیمت‌گذاری طلای دست دوم</a> مراجعه کنید.
            </p>
        </div>
    </section>

    {{-- بخش مطالب و ابزارهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'ابزارها و راهنماهای مرتبط با عیارسنجی طلا',
        'links' => [
            [
                'title' => 'محاسبه‌گر طلای آبشده و وزن شرطی',
                'desc' => 'تبدیل عیار ری‌گیری به وزن خطی با نرخ لحظه‌ای طلای ۱۸ عیار.',
                'url' => route('public.tools.melted-gold'),
            ],
            [
                'title' => 'قیمت‌گذاری طلای دست دوم',
                'desc' => 'محاسبه‌گر آنلاین خرید طلای مستعمل با عیار ۷۴۰ و ۷۵۰ و کسر افت.',
                'url' => route('public.tools.second-hand-gold'),
            ],
            [
                'title' => 'استعلام انگ طلا و ری‌گیری',
                'desc' => 'راهنمای کامل خواندن کد انگ، شماره پاکت و استعلام جواب ری‌گیری رسمی.',
                'url' => route('public.guides.show', 'gold-hallmark-inquiry'),
            ],
        ]
    ])

</div>
@endsection
