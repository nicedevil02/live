@extends('layouts.public')

@section('title', 'محاسبه طلای آب‌شده | محاسبه وزن شرطی و عیار انگ ری‌گیری | طلالایو')
@section('meta_description', 'ابزار آنلاین محاسبه طلای آب‌شده برای تبدیل وزن و عیار انگ ری‌گیری به وزن شرطی ۷۵۰ با نرخ لحظه‌ای به همراه تحلیل مفهوم آبشده نقدی و تفاوت با نرخ اتحادیه.')
@section('canonical', 'https://talalive.ir/tools/melted-gold')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "محاسبه‌گر تخصصی طلای آب شده و طلای آبشده",
      "alternateName": [
        "طلای آب شده",
        "طلای آبشده",
        "آبشده نقدی",
        "محاسبه طلای آب شده",
        "فرمول طلای آبشده",
        "محاسبه آنلاین طلای آب شده"
      ],
      "url": "https://talalive.ir/tools/melted-gold",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار محاسبه وزن شرطی و ارزش قطعات طلای آب شده بر اساس عیار ری‌گیری و نرخ روز طلای ۱۸ عیار و تابلوی آبشده نقدی."
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
          "name": "محاسبه‌گر طلای آب شده",
          "item": "https://talalive.ir/tools/melted-gold"
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
            <span>ابزار استاندارد معاملات بنکداری و کیفی‌های طلا • سال ۱۴۰۵</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            محاسبه‌گر آنلاین طلای آب شده و آبشده نقدی <br>
            <span class="text-amber-500">تبدیل عیار انگ به وزن شرطی ۱۸ عیار (۷۵۰)</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm">
            محاسبه آنی ارزش ریالی بر اساس نرخ روز طلای ۱۸ عیار و تابلوی بازار بنکداران
        </p>
        <p class="text-xs text-slate-500 dark:text-slate-400">
            نرخ تابلوی هر گرم طلای ۱۸ عیار: <strong class="text-amber-500 font-mono">{{ number_format($rates['gold18']) }}</strong> تومان (بروزرسانی: {{ $lastUpdated }})
        </p>
    </div>

    {{-- ویجت آلپاین طلای آبشده --}}
    <div x-data="{
        rawWeight: 50.25,
        engKarat: 735,
        gold18Rate: {{ $rates['gold18'] > 0 ? $rates['gold18'] : 4500000 }},
        get conditionalWeight() {
            const w = parseFloat(this.rawWeight) || 0;
            const k = parseFloat(this.engKarat) || 750;
            return parseFloat(((w * k) / 750).toFixed(3));
        },
        get totalValue() {
            return Math.round(this.conditionalWeight * (parseFloat(this.gold18Rate) || 0));
        },
        formatNumber(num) {
            return (num || 0).toLocaleString('fa-IR');
        }
    }" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-8">
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">وزن ترازوی آبشده (گرم):</label>
                <input type="number" step="0.01" min="0.01" x-model.number="rawWeight" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">عیار انگ ری‌گیری (مثلاً ۷۳۵ یا ۷۶۰):</label>
                <input type="number" step="1" min="100" max="1000" x-model.number="engKarat" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">قیمت هر گرم ۱۸ عیار (تومان):</label>
                <input type="number" step="1000" min="10000" x-model.number="gold18Rate" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500">
            </div>
        </div>

        {{-- خروجی محاسبات آبشده --}}
        <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/60 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <span class="text-xs text-slate-500">وزن شرطی (معادل طلای ۱۸ عیار ۷۵۰):</span>
                    <div class="text-xl font-black text-amber-500 mt-1">
                        <span x-text="conditionalWeight"></span> گرم
                    </div>
                </div>
                <div class="p-4 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">
                    <span class="text-xs text-slate-500">ارزش کل قطعه آبشده:</span>
                    <div class="text-xl font-black text-emerald-500 mt-1">
                        <span x-text="formatNumber(totalValue)"></span> تومان
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- بخش تحلیلی: مفهوم آبشده نقدی و نسبتش با نرخ اتحادیه --}}
    <section class="space-y-6">
        <div class="text-center space-y-3">
            <h2 class="text-2xl font-black text-slate-900 dark:text-white">
                مفهوم «آبشده نقدی» و نسبتش با نرخ مصوب اتحادیه
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm max-w-3xl mx-auto">
                در بازار طلا دو نرخ برای طلای آبشده مطرح است: نرخ تابلوی اعلامی اتحادیه و نرخ آبشده نقدی سبزه میدان؛ تفاوت این دو مفهوم در چیست؟
            </p>
        </div>

        <div class="grid sm:grid-cols-2 gap-6">
            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-md">
                <span class="px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 text-[11px] font-bold">معاملات زنده سبزه میدان</span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">آبشده نقدی چیست؟</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    <strong>آبشده نقدی</strong> به نرخ معامله لحظه‌ای و تسویه نقدی شمش‌های آبشده دارای انگ معتبر در بازار عمده‌فروشی (سبزه میدان و راسته زرگران) گفته می‌شود. این نرخ ثانیه‌ای و بر اساس نوسانات لحظه‌ای عرضه و تقاضا، نرخ تتر و اونس طلا نوسان می‌کند و معامله‌گران بزرگ بر مبنای آن حساب‌های خود را تسویه می‌کنند.
                </p>
            </div>

            <div class="p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 space-y-3 shadow-md">
                <span class="px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-[11px] font-bold">نرخ رسمی پایگاه اتحادیه</span>
                <h3 class="text-base font-black text-slate-900 dark:text-white">نسبت با نرخ اتحادیه</h3>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                    نرخ اتحادیه معمولاً یک بار در روز در ساعات ظهر کشف و منتشر می‌شود و به عنوان مرجع نظارتی اصناف کاربرد دارد. اما آبشده نقدی به دلیل تغییرات پیوسته بازار در طول روز می‌تواند بالاتر یا پایین‌تر از نرخ اتحادیه معامله شود. طلالایو در <a href="{{ route('public.online-gold-price-board') }}" class="text-amber-500 font-bold hover:underline">تابلو آنلاین قیمت طلا</a> هر دو نرخ را همزمان بروزرسانی می‌کند.
                </p>
            </div>
        </div>
    </section>

    {{-- جدول مقایسه آبشده نقدی، آبشده شرطی و شمش استاندارد --}}
    <section class="space-y-4">
        <h3 class="text-lg font-black text-slate-900 dark:text-white">
            جدول مقایسه آبشده نقدی، آبشده شرطی و شمش استاندارد
        </h3>
        <div class="overflow-x-auto rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-lg">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-black border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="p-4 sm:p-5">نوع طلای خام</th>
                        <th class="p-4 sm:p-5 text-amber-500">وضعیت انگ و عیار</th>
                        <th class="p-4 sm:p-5">مبنای تسویه مالی</th>
                        <th class="p-4 sm:p-5">وضعیت اجرت و مالیات</th>
                        <th class="p-4 sm:p-5">کاربرد اصلی در صنف</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                        <td class="p-4 sm:p-5 font-bold">آبشده نقدی</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">دارای کد انگ رسمی و جواب قطعی</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">تسویه آنی طبق نرخ زنده سبزه میدان</td>
                        <td class="p-4 sm:p-5 text-xs text-emerald-600 dark:text-emerald-400 font-bold">معاف از اجرت و ۹٪ ارزش افزوده</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">پشتوانه ویترین و دادوستد بنکداری</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                        <td class="p-4 sm:p-5 font-bold">آبشده شرطی</td>
                        <td class="p-4 sm:p-5 text-amber-600 dark:text-amber-400 font-bold">فاقد انگ یا مشکوک به ناهمگنی</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">تسویه موقت بر مبنای عیار ۷۵۰ تا دریافت جواب</td>
                        <td class="p-4 sm:p-5 text-xs text-emerald-600 dark:text-emerald-400 font-bold">معاف از اجرت و مالیات</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">خرید طلای ضایعاتی از همکاران صنف</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                        <td class="p-4 sm:p-5 font-bold">شمش استاندارد ۲۴ عیار</td>
                        <td class="p-4 sm:p-5 text-cyan-600 dark:text-cyan-400 font-bold">شمش وکیوم ۹۹۹.۹ دارای سرتیفیکیت</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">قیمت بر مبنای انس جهانی و دلار آزاد</td>
                        <td class="p-4 sm:p-5 text-xs text-emerald-600 dark:text-emerald-400 font-bold">معاف از ارزش افزوده اصل طلا</td>
                        <td class="p-4 sm:p-5 text-xs text-slate-500 dark:text-slate-400">سرمایه‌گذاری کلان و ذخیره دارایی</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    {{-- راهنمای فرمول و لینک‌ها --}}
    <div class="glass-panel p-6 sm:p-10 rounded-3xl border border-slate-200 dark:border-slate-800 space-y-4 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
        <h3 class="font-black text-slate-900 dark:text-white text-base flex items-center gap-2">
            <span>📚</span>
            <span>فرمول محاسبه آنلاین طلای آب‌شده و وزن شرطی</span>
        </h3>
        <p>
            فرمول تبدیل وزن ترازوی طلای آب شده به وزن شرطی ۷۵۰ (معادل ۱۸ عیار استاندارد) عبارت است از:
        </p>
        <div class="p-4 rounded-2xl bg-amber-500/10 border border-amber-500/20 font-mono text-center font-bold text-amber-700 dark:text-amber-300 dir-ltr">
            وزن شرطی ۱۸ عیار = (وزن ترازو × عیار انگ) ÷ ۷۵۰
        </div>
        <p>
            از آنجا که به معاملات طلای آب شده هیچ‌گونه اجرت ساخت یا مالیات تعلق نمی‌گیرد، این ابزار مطمئن‌ترین روش برای سرمایه‌گذاران بازار طلا، بنکداران و فعالان مغازه طلا فروشی است.
        </p>
        <p class="pt-2 border-t border-slate-200 dark:border-slate-700/60">
            💡 اگر مشتری قصد تعویض یا فروش زیورآلات مستعمل خود را دارد، راهنمای <a href="{{ route('public.guides.show', 'motefareghe-18') }}" class="text-amber-600 dark:text-amber-400 font-bold underline hover:text-amber-500">تعویض و خرید متفرقه ۱۸ چیست؟</a> را برای یادگیری نحوه کسر افت و محاسبات فاکتور مطالعه فرمایید. همچنین با ابزار تخصصی <a href="{{ route('public.tools.second-hand-gold') }}" class="text-amber-600 dark:text-amber-400 font-bold underline hover:text-amber-500">قیمت‌گذاری طلای دست دوم</a> ارزش قطعات کارکرده را پیش از ارسال به کوره ری‌گیری محاسبه نمایید. جهت آشنایی با شماره پاکت و اعتبارسنجی کدها نیز راهنمای <a href="{{ route('public.guides.show', 'gold-hallmark-inquiry') }}" class="text-amber-600 dark:text-amber-400 font-bold underline hover:text-amber-500">استعلام انگ طلا و ری‌گیری</a> در دسترس شماست.
        </p>
    </div>

    {{-- بخش مطالب و ابزارهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'ابزارها و راهنماهای مرتبط با طلای آبشده و عیارسنجی',
        'links' => [
            [
                'title' => 'تبدیل آنلاین عیار طلا',
                'desc' => 'جدول و ابزار تبدیل انواع عیارهای ۷۵۰، ۷۰۵، ۷۴۰ و ۹۹۹ به یکدیگر.',
                'url' => route('public.tools.karat-converter'),
            ],
            [
                'title' => 'قیمت‌گذاری طلای دست دوم',
                'desc' => 'محاسبه‌گر ارزش خرید طلای مستعمل پیش از ذوب و ارسال به ری‌گیری.',
                'url' => route('public.tools.second-hand-gold'),
            ],
            [
                'title' => 'استعلام انگ طلا و ری‌گیری',
                'desc' => 'راهنمای کامل خواندن شماره پاکت و عیار روی شمش آبشده.',
                'url' => route('public.guides.show', 'gold-hallmark-inquiry'),
            ],
        ]
    ])

</div>
@endsection
