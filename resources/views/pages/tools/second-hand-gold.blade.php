@extends('layouts.public')

@section('title', config('seo.pages.tools/second-hand-gold.title'))
@section('meta_description', config('seo.pages.tools/second-hand-gold.desc'))
@section('canonical', 'https://talalive.ir/tools/second-hand-gold')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "محاسبه‌گر آنلاین قیمت‌گذاری طلای دست دوم",
      "alternateName": [
        "قیمت‌گذاری طلای دست دوم",
        "طلای مستعمل",
        "کسر افت طلا",
        "طلای کارکرده"
      ],
      "url": "https://talalive.ir/tools/second-hand-gold",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار تخصصی و آنلاین قیمت‌گذاری طلای دست دوم و مستعمل با محاسبه کسر افت وزنی، نگین و تبدیل عیار به نرخ روز طلای ۱۸ عیار."
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
          "name": "ابزارهای طلا",
          "item": "https://talalive.ir/gold-calculator"
        },
        {
          "@@type": "ListItem",
          "position": 3,
          "name": "قیمت‌گذاری طلای دست دوم",
          "item": "https://talalive.ir/tools/second-hand-gold"
        }
      ]
    }
  ]
}
</script>
@endsection

@section('content')
<div class="py-12 sm:py-20 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto space-y-12">

    {{-- هدر صفحه با تعریف صریح موضوع --}}
    <div class="text-center space-y-4 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-600 dark:text-amber-400 text-xs font-bold">
            <span>فرمول استاندارد بازار و اتحادیه طلا و جواهر • سال ۱۴۰۵</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            قیمت‌گذاری طلای دست دوم و محاسبه ارزش خرید طلاهای مستعمل
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed text-justify sm:text-center">
            قیمت‌گذاری طلای دست دوم فرآیند تعیین بهای وزنی مصنوعات کارکرده یا مستعمل بر مبنای نرخ خام طلای ۱۸ عیار روز پس از اعمال کسر افت، ناخالصی نگین و عیارسنجی کارگاهی است.
        </p>
        <p class="text-slate-500 dark:text-slate-400 text-xs">
            نرخ مبنای طلای ۱۸ عیار در تابلو: <strong class="text-amber-500">{{ number_format($rates['gold18']) }}</strong> تومان (بروزرسانی: {{ $lastUpdated }})
        </p>
    </div>

    {{-- ویجت محاسبه‌گر طلای دست دوم آلپاین --}}
    <div x-data="{
        grossWeight: 7.8,
        karat: 750,
        wasteWeight: 0.15, // کسر افت و نگین به گرم
        discountType: 'fixed', // 'fixed' (تومان زیر تابلو) or 'percent' (درصد کسر متفرقه)
        fixedDiscountPerGram: 35000,
        percentDiscount: 1.5,
        ratePerGram: {{ $rates['gold18'] > 0 ? $rates['gold18'] : 4500000 }},

        get netKarat750Weight() {
            const gw = parseFloat(this.grossWeight) || 0;
            const ww = parseFloat(this.wasteWeight) || 0;
            const k = parseFloat(this.karat) || 750;
            const netRaw = Math.max(0, gw - ww);
            // تبدیل به معادل ۱۸ عیار استاندارد (۷۵۰)
            return parseFloat(((netRaw * k) / 750).toFixed(3));
        },
        get baseBoardValue() {
            return Math.round(this.netKarat750Weight * (parseFloat(this.ratePerGram) || 0));
        },
        get shopMarginTotal() {
            if (this.discountType === 'fixed') {
                const f = parseFloat(this.fixedDiscountPerGram) || 0;
                return Math.round(this.netKarat750Weight * f);
            } else {
                const p = parseFloat(this.percentDiscount) || 0;
                return Math.round(this.baseBoardValue * (p / 100));
            }
        },
        get finalPayoutTotal() {
            return Math.max(0, this.baseBoardValue - this.shopMarginTotal);
        },
        get effectivePricePerGram() {
            const gw = parseFloat(this.grossWeight) || 0;
            if (gw <= 0) return 0;
            return Math.round(this.finalPayoutTotal / gw);
        },
        formatNumber(num) {
            return (num || 0).toLocaleString('fa-IR');
        }
    }" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-8">

        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mb-2">
                محاسبه‌گر آنلاین ارزش خرید و فروش طلای دست دوم و کم‌اجرت
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">
                وزن ترازو و مشخصات زیورآلات کارکرده خود را وارد کنید تا ارزش تسویه نقدی با کسر افت دقیق محاسبه شود:
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- وزن کل روی ترازو --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">وزن کل روی ترازو (گرم):</label>
                <input type="number" step="0.01" min="0.01" x-model.number="grossWeight" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
            </div>

            {{-- عیار قطعه --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">عیار کارشناسی قطعه طلا:</label>
                <select x-model.number="karat" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
                    <option value="750">۱۸ عیار استاندارد رسمی (۷۵۰)</option>
                    <option value="740">طلای متفرقه سبک کارگاهی (۷۴۰)</option>
                    <option value="705">طلای متفرقه قدیمی یا هندی (۷۰۵)</option>
                    <option value="999">۲۴ عیار / شمش خالص (۹۹۹)</option>
                </select>
            </div>

            {{-- کسر افت ناخالصی و نگین --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">کسر افت ناخالصی، نگین و چسب (گرم):</label>
                <input type="number" step="0.01" min="0" x-model.number="wasteWeight" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
                <span class="text-[10px] text-slate-400">برای کار بدون نگین معمولاً ۰.۰۵ تا ۰.۱ گرم کسر می‌شود</span>
            </div>

            {{-- قیمت هر گرم طلای ۱۸ عیار روز --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">نرخ تابلوی هر گرم طلای ۱۸ عیار (تومان):</label>
                <input type="number" step="1000" min="10000" x-model.number="ratePerGram" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
            </div>

            {{-- مدل حاشیه کسر خرید متفرقه --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">حاشیه خرید طلافروش:</label>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" @click="discountType = 'fixed'" :class="discountType === 'fixed' ? 'bg-amber-500 text-slate-950 font-black' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold'" class="py-3 rounded-2xl text-xs transition-colors cursor-pointer text-center">
                        تومان زیر تابلو
                    </button>
                    <button type="button" @click="discountType = 'percent'" :class="discountType === 'percent' ? 'bg-amber-500 text-slate-950 font-black' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold'" class="py-3 rounded-2xl text-xs transition-colors cursor-pointer text-center">
                        درصدی (%)
                    </button>
                </div>
            </div>

            {{-- مقدار کسر خرید --}}
            <div class="space-y-2" x-show="discountType === 'fixed'">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">کسر هر گرم زیر تابلو (تومان):</label>
                <input type="number" step="5000" min="0" x-model.number="fixedDiscountPerGram" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
                <span class="text-[10px] text-slate-400">عرف بازار: ۲۰,۰۰۰ تا ۵۰,۰۰۰ تومان زیر تابلو</span>
            </div>

            <div class="space-y-2" x-show="discountType === 'percent'">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">درصد کسر خرید متفرقه (%):</label>
                <input type="number" step="0.5" min="0" max="10" x-model.number="percentDiscount" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
                <span class="text-[10px] text-slate-400">عرف بازار: ۱٪ تا ۲٪ ارزش طلا</span>
            </div>
        </div>

        {{-- کادر نتایج تسویه نقدی --}}
        <div class="mt-8 rounded-3xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-slate-200 dark:border-slate-700">
                <div>
                    <span class="text-xs text-amber-500 font-bold">مبلغ خالص تسویه به مشتری</span>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">ارزش نهایی خرید طلای مستعمل</h3>
                </div>
                <div class="text-left sm:text-right">
                    <div class="text-2xl sm:text-3xl font-black text-amber-500" x-text="formatNumber(finalPayoutTotal) + ' تومان'"></div>
                    <div class="text-[11px] text-slate-400 mt-1">
                        میانگین دریافتی هر گرم ناخالص: <span class="font-bold text-slate-700 dark:text-slate-200" x-text="formatNumber(effectivePricePerGram) + ' تومان'"></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                    <span class="text-xs text-slate-500 dark:text-slate-400">وزن خالص معادل ۱۸ عیار:</span>
                    <div class="text-base sm:text-lg font-black text-slate-900 dark:text-white mt-1" x-text="netKarat750Weight + ' گرم'"></div>
                    <span class="text-[10px] text-slate-400">پس از کسر افت و تبدیل عیار</span>
                </div>

                <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                    <span class="text-xs text-slate-500 dark:text-slate-400">ارزش خام بر مبنای تابلو:</span>
                    <div class="text-base sm:text-lg font-black text-slate-900 dark:text-white mt-1" x-text="formatNumber(baseBoardValue) + ' تومان'"></div>
                    <span class="text-[10px] text-slate-400">وزن خالص × نرخ تابلوی مغازه</span>
                </div>

                <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                    <span class="text-xs text-slate-500 dark:text-slate-400">حاشیه سود خرید طلافروش:</span>
                    <div class="text-base sm:text-lg font-black text-slate-900 dark:text-white mt-1" x-text="formatNumber(shopMarginTotal) + ' تومان'"></div>
                    <span class="text-[10px] text-rose-400">کسر بابت ریسک ذوب و تبدیل</span>
                </div>

                <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                    <span class="text-xs text-slate-500 dark:text-slate-400">کسر افت وزنی ناخالصی:</span>
                    <div class="text-base sm:text-lg font-black text-amber-500 mt-1" x-text="wasteWeight + ' گرم'"></div>
                    <span class="text-[10px] text-slate-400">وزن نگین، چسب و رسوبات</span>
                </div>
            </div>
        </div>
    </div>

    {{-- جدول مقایسه افت وزنی رایج در انواع مصنوعات مستعمل --}}
    <section class="space-y-6">
        <div class="text-center space-y-3">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                جدول مقایسه افت وزنی رایج در انواع مصنوعات مستعمل
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm max-w-3xl mx-auto">
                هنگام فروش طلای کارکرده، بر اساس نوع کار و اتصالات میزان کسر افت وزنی به شرح زیر محاسبه می‌شود:
            </p>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xl">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-black border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="p-4 sm:p-5">نوع مصنوع طلای کارکرده</th>
                        <th class="p-4 sm:p-5 text-amber-500">میانگین کسر افت یا ناخالصی</th>
                        <th class="p-4 sm:p-5">دلیل فنی کسر افت</th>
                        <th class="p-4 sm:p-5">توصیه به فروشنده</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold">النگو بدون نگین و تراش ساده</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">۰.۰۱ تا ۰.۰۵ گرم</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">جرم و رسوب صابون و تعریق پوست در لایه‌های داخلی النگو.</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">قبل از فروش با آب گرم و مایع شوینده النگو را شستشو دهید.</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold">زنجیر و دستبند کارکرده</td>
                        <td class="p-4 sm:p-5 text-amber-600 dark:text-amber-400 font-bold">۰.۰۵ تا ۰.۱۵ گرم</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">فنر داخل قفل (استیل آهن‌ربایی) و فلز لحیم دانه‌ها.</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">وجود فنر قفل جزو استانداردهای ساخت است و افت آن طبیعی است.</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold">انگشتر و گوشواره نگین‌دار اتمی</td>
                        <td class="p-4 sm:p-5 text-rose-500 font-bold">۰.۲ تا ۱.۵ گرم (کسر کامل)</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">نگین‌های اتمی شیشه‌ای ارزش بازیافت نداشته و وزنشان تماماً کسر می‌شود.</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">از طلافروش بخواهید وزن کسر نگین را متناسب با سنگ‌های فاکتور اصلی کسر کند.</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold">پلاک‌های چسب‌دار و میناکاری</td>
                        <td class="p-4 sm:p-5 text-amber-600 dark:text-amber-400 font-bold">۰.۱ تا ۰.۵ گرم</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">وزن رنگ‌های لعابی مینا یا رزین و چسب‌های نگهدارنده نگین.</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">این محصولات هنگام خرید اجرت بالا دارند اما هنگام فروش افت زیادی دارند.</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold">طلای شکسته متفرقه و بدون فاکتور</td>
                        <td class="p-4 sm:p-5 text-rose-500 font-bold">تبدیل عیار به ۷۴۰ تا ۷۰۵</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">لحیم‌های زیاد در قطعات شکسته باعث کاهش عیار میانگین قطعه به زیر ۷۵۰ می‌شود.</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">فروش با ری‌گیری کارگاهی به عنوان طلای آبشده در این موارد منصفانه‌تر است.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-[11px] text-slate-500 dark:text-slate-400 text-center">
            * مقادیر کسر افت فوق تجربی و بر مبنای عرف صنف طلا و جواهر در سال ۱۴۰۵ تهیه شده و توافق نهایی میان خریدار و فروشنده ملاک است.
        </p>
    </section>

    {{-- بنر فراخوان میانی --}}
    @include('partials.cta-inline', [
        'title' => 'تابلوی هوشمند طلالایو؛ نمایش دوگانه نرخ خرید متفرقه و فروش ویترین',
        'subtitle' => 'با سیستم چندنرخی طلالایو، تابلوی تلویزیون گالری شما علاوه بر نرخ فروش، نرخ رسمی خرید متفرقه ۱۸ را طبق فرمول خودکار برای مشتریان شفاف‌سازی می‌کند.',
        'buttonText' => 'تست رایگان ۱۴ روزه تابلوی هوشمند',
        'buttonUrl' => route('admin.register'),
        'secondaryText' => 'راهنمای تابلوی بدون دستگاه',
        'secondaryUrl' => route('public.gold-board-without-device'),
    ])

    {{-- مقالات آموزشی کسر افت و عیارسنجی --}}
    <section class="grid sm:grid-cols-2 gap-8 items-start">
        <div class="space-y-4 p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
            <h2 class="text-xl font-black text-slate-900 dark:text-white">
                کسر افت طلا چیست و چرا طلافروشان از وزن طلا کسر می‌کنند؟
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                هنگامی که شما یک زیورآلات کارکرده مانند دستبند یا گردنبند را می‌فروشید، طلافروش آن را به عنوان <strong>طلای مستعمل</strong> یا طلای ضایعاتی می‌خرد تا برای ذوب به آزمایشگاه ری‌گیری ارسال کند. در فرآیند ذوب در کوره بوته، ناخالصی‌ها از جمله چربی، چسب نگین و فنر استیل تبخیر شده و می‌سوزند. بنابراین کسر افت برای جبران همین کاهش وزن واقعی در بوته ذوب اعمال می‌شود.
            </p>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                برای درک بهتر تفاوت خرید متفرقه با تعویض، می‌توانید مقاله تخصصی <a href="{{ route('public.guides.show', 'motefareghe-18') }}" class="text-amber-500 font-bold hover:underline">تعویض و خرید متفرقه ۱۸ چیست؟</a> را مطالعه نمایید.
            </p>
        </div>

        <div class="space-y-4 p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
            <h2 class="text-xl font-black text-slate-900 dark:text-white">
                روش‌های عیارسنجی طلای دست دوم در مغازه (سنگ محک و کوپلاسیون)
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                طلافروش پیش از پرداخت وجه، سلامت و عیار کارکرده را با سنگ محک و اسید نیتریک بررسی می‌کند:
            </p>
            <ul class="space-y-3 text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                <li class="flex items-start gap-2">
                    <span class="text-amber-500 font-bold">۱. آزمون سنگ محک و اسید:</span>
                    <span>خط کشیدن روی سنگ محک سیلیسی و ریختن قطره تیزاب سلطانی؛ در صورتی که اثر طلایی محو نشود عیار ۷۵۰ تأیید می‌شود.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-amber-500 font-bold">۲. کوپلاسیون در ری‌گیری:</span>
                    <span>در صورت حجم بالای طلا، قطعه ذوب شده و در آزمایشگاه‌های رسمی ری‌گیری با دقت یک در هزار انگ زده می‌شود. ابزار <a href="{{ route('public.tools.melted-gold') }}" class="text-amber-500 font-bold hover:underline">محاسبه‌گر طلای آبشده</a> فرمول این فرآیند را محاسبه می‌کند.</span>
                </li>
            </ul>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed pt-2 border-t border-slate-100 dark:border-slate-800">
                اگر قصد خرید طلای نو با اجرت منصفانه دارید، از ابزار <a href="{{ route('public.tools.wage-calculator') }}" class="text-amber-500 font-bold hover:underline">محاسبه اجرت طلا</a> برای تفکیک فاکتور بهره بگیرید.
            </p>
        </div>
    </section>

    {{-- بخش مطالب و ابزارهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'ابزارها و راهنماهای مرتبط با طلای دست دوم و متفرقه',
        'links' => [
            [
                'title' => 'تعویض و خرید متفرقه ۱۸ چیست؟',
                'desc' => 'تفاوت نرخ خرید طلای شکسته و تعویض با طلای نو به همراه نحوه نمایش در تابلوی مغازه.',
                'url' => route('public.guides.show', 'motefareghe-18'),
            ],
            [
                'title' => 'محاسبه‌گر طلای آبشده و عیار شرطی',
                'desc' => 'محاسبه خط ری‌گیری، پاکت انگ و تبدیل مظنه آبشده به طلای استاندارد ۷۵۰.',
                'url' => route('public.tools.melted-gold'),
            ],
            [
                'title' => 'ماشین‌حساب محاسبه اجرت طلا',
                'desc' => 'جدول درصد اجرت ساخت و تفکیک اجزای فاکتور خرید طلا با سود قانونی.',
                'url' => route('public.tools.wage-calculator'),
            ],
        ]
    ])

</div>
@endsection
