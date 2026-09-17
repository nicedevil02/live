@extends('layouts.public')

@section('title', config('seo.pages.tools/wage-calculator.title'))
@section('meta_description', config('seo.pages.tools/wage-calculator.desc'))
@section('canonical', 'https://talalive.ir/tools/wage-calculator')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "WebApplication",
      "name": "ماشین حساب آنلاین محاسبه اجرت طلا",
      "alternateName": [
        "محاسبه اجرت طلا",
        "درصد اجرت طلا",
        "جدول اجرت طلا",
        "اجرت ساخت طلا"
      ],
      "url": "https://talalive.ir/tools/wage-calculator",
      "applicationCategory": "FinanceApplication",
      "operatingSystem": "All",
      "description": "ابزار آنلاین و رایگان محاسبه درصد اجرت ساخت طلا، تفکیک سود ۷ درصد طلافروشی و مالیات ارزش افزوده فاکتور به همراه جدول درصد اجرت انواع مصنوعات سال ۱۴۰۵."
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
          "name": "محاسبه اجرت طلا",
          "item": "https://talalive.ir/tools/wage-calculator"
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
            <span>فرمول رسمی اتحادیه طلا و جواهر کشور • سال ۱۴۰۵</span>
        </div>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white leading-tight">
            محاسبه اجرت طلا و تفکیک اجزای فاکتور با فرمول قانونی صنف
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed text-justify sm:text-center">
            محاسبه اجرت طلا فرآیند تعیین هزینه ساخت، تراش و طراحی مصنوعات زینتی علاوه بر ارزش خام طلا است که به‌صورت درصدی یا مبلغ ثابت به ازای هر گرم بر فاکتور خرید افزوده می‌شود.
        </p>
        <p class="text-slate-500 dark:text-slate-400 text-xs">
            نرخ مبنای هر گرم طلای ۱۸ عیار در سامانه: <strong class="text-amber-500">{{ number_format($rates['gold18']) }}</strong> تومان (بروزرسانی: {{ $lastUpdated }})
        </p>
    </div>

    {{-- ویجت محاسبه‌گر اجرت آلپاین --}}
    <div x-data="{
        weight: 5.2,
        ratePerGram: {{ $rates['gold18'] > 0 ? $rates['gold18'] : 4500000 }},
        wageType: 'percent', // 'percent' or 'fixed'
        wagePercent: 16,
        wageFixedPerGram: 600000,
        profitPercent: 7,
        vatPercent: 9,

        get rawGoldTotal() {
            const w = parseFloat(this.weight) || 0;
            const r = parseFloat(this.ratePerGram) || 0;
            return Math.round(w * r);
        },
        get wageTotal() {
            const w = parseFloat(this.weight) || 0;
            const r = parseFloat(this.ratePerGram) || 0;
            if (this.wageType === 'percent') {
                const p = parseFloat(this.wagePercent) || 0;
                return Math.round((w * r) * (p / 100));
            } else {
                const f = parseFloat(this.wageFixedPerGram) || 0;
                return Math.round(w * f);
            }
        },
        get effectiveWagePercent() {
            if (this.rawGoldTotal <= 0) return 0;
            return ((this.wageTotal / this.rawGoldTotal) * 100).toFixed(1);
        },
        get profitTotal() {
            const p = parseFloat(this.profitPercent) || 0;
            return Math.round((this.rawGoldTotal + this.wageTotal) * (p / 100));
        },
        get vatTotal() {
            const v = parseFloat(this.vatPercent) || 0;
            // بر اساس قانون جدید مالیات بر ارزش افزوده، مالیات منحصراً بر مجموع اجرت و سود اعمال می‌شود نه اصل طلا
            return Math.round((this.wageTotal + this.profitTotal) * (v / 100));
        },
        get finalInvoiceTotal() {
            return this.rawGoldTotal + this.wageTotal + this.profitTotal + this.vatTotal;
        },
        get extraCostPercent() {
            if (this.rawGoldTotal <= 0) return 0;
            return (((this.finalInvoiceTotal - this.rawGoldTotal) / this.rawGoldTotal) * 100).toFixed(1);
        },
        formatNumber(num) {
            return (num || 0).toLocaleString('fa-IR');
        }
    }" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl space-y-8">

        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white mb-2">
                ماشین‌حساب آنلاین محاسبه درصد اجرت ساخت و فاکتور نهایی طلا
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm">
                وزن و نوع اجرت مصنوع را وارد کنید تا اجزای فاکتور، سود طلافروش و مالیات قانونی تفکیک و محاسبه شوند:
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- وزن طلا --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">وزن طلا (گرم):</label>
                <input type="number" step="0.01" min="0.01" x-model.number="weight" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
            </div>

            {{-- قیمت هر گرم طلای ۱۸ عیار --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">قیمت هر گرم طلای ۱۸ عیار (تومان):</label>
                <input type="number" step="1000" min="10000" x-model.number="ratePerGram" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
            </div>

            {{-- روش محاسبه اجرت ساخت --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">روش محاسبه اجرت ساخت:</label>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" @click="wageType = 'percent'" :class="wageType === 'percent' ? 'bg-amber-500 text-slate-950 font-black' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold'" class="py-3 rounded-2xl text-xs transition-colors cursor-pointer text-center">
                        درصدی (%)
                    </button>
                    <button type="button" @click="wageType = 'fixed'" :class="wageType === 'fixed' ? 'bg-amber-500 text-slate-950 font-black' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold'" class="py-3 rounded-2xl text-xs transition-colors cursor-pointer text-center">
                        مبلغی (تومان/گرم)
                    </button>
                </div>
            </div>

            {{-- فیلد متغیر اجرت ساخت --}}
            <div class="space-y-2" x-show="wageType === 'percent'">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">درصد اجرت ساخت (%):</label>
                <input type="number" step="0.5" min="0" max="60" x-model.number="wagePercent" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
            </div>

            <div class="space-y-2" x-show="wageType === 'fixed'">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">مبلغ اجرت ساخت هر گرم (تومان):</label>
                <input type="number" step="10000" min="0" x-model.number="wageFixedPerGram" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
            </div>

            {{-- سود فروشنده طلا --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">سود مصوب طلافروشی (%):</label>
                <input type="number" step="0.5" min="0" max="20" x-model.number="profitPercent" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
                <span class="text-[10px] text-slate-400">سقف قانونی مصوب اتحادیه: ۷ درصد</span>
            </div>

            {{-- مالیات ارزش افزوده --}}
            <div class="space-y-2">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300">مالیات بر ارزش افزوده (%):</label>
                <input type="number" step="1" min="0" max="15" x-model.number="vatPercent" class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-bold text-base focus:outline-none focus:border-amber-500 transition-colors">
                <span class="text-[10px] text-emerald-500 font-bold">فقط روی اجرت و سود (معافیت اصل طلا)</span>
            </div>
        </div>

        {{-- کادر نتایج و فاکتور تفکیکی --}}
        <div class="mt-8 rounded-3xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-6 border-b border-slate-200 dark:border-slate-700">
                <div>
                    <span class="text-xs text-amber-500 font-bold">فاکتور نهایی شفاف</span>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">مبلغ قابل پرداخت فاکتور خرید طلا</h3>
                </div>
                <div class="text-left sm:text-right">
                    <div class="text-2xl sm:text-3xl font-black text-amber-500" x-text="formatNumber(finalInvoiceTotal) + ' تومان'"></div>
                    <div class="text-[11px] text-slate-400 mt-1">
                        اضافه‌بهای کل نسبت به طلای خام: <span class="font-bold text-amber-600 dark:text-amber-400" x-text="extraCostPercent + '٪'"></span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                    <span class="text-xs text-slate-500 dark:text-slate-400">بهای طلای خام:</span>
                    <div class="text-base sm:text-lg font-black text-slate-900 dark:text-white mt-1" x-text="formatNumber(rawGoldTotal) + ' تومان'"></div>
                    <span class="text-[10px] text-slate-400">وزن × نرخ ۱۸ عیار</span>
                </div>

                <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                    <span class="text-xs text-slate-500 dark:text-slate-400">اجرت ساخت سازنده:</span>
                    <div class="text-base sm:text-lg font-black text-slate-900 dark:text-white mt-1" x-text="formatNumber(wageTotal) + ' تومان'"></div>
                    <span class="text-[10px] text-amber-500 font-bold" x-text="'معادل ' + effectiveWagePercent + '٪ ارزش طلا'"></span>
                </div>

                <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                    <span class="text-xs text-slate-500 dark:text-slate-400">سود مصوب فروشنده (۷٪):</span>
                    <div class="text-base sm:text-lg font-black text-slate-900 dark:text-white mt-1" x-text="formatNumber(profitTotal) + ' تومان'"></div>
                    <span class="text-[10px] text-slate-400">محاسبه روی طلا + اجرت</span>
                </div>

                <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700">
                    <span class="text-xs text-slate-500 dark:text-slate-400">مالیات بر ارزش افزوده (۹٪):</span>
                    <div class="text-base sm:text-lg font-black text-slate-900 dark:text-white mt-1" x-text="formatNumber(vatTotal) + ' تومان'"></div>
                    <span class="text-[10px] text-emerald-500 font-bold">۹٪ روی (اجرت + سود)</span>
                </div>
            </div>
        </div>
    </div>

    {{-- جدول درصد اجرت رایج انواع مصنوعات طلا در سال ۱۴۰۵ --}}
    <section class="space-y-6">
        <div class="text-center space-y-3">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                جدول درصد اجرت رایج انواع مصنوعات طلا در سال ۱۴۰۵
            </h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm max-w-3xl mx-auto">
                میانگین درصد اجرت ساخت و دستمزد کارگاه‌ها بر اساس تکنیک ساخت، میزان پرت طلا، تراش و نگین‌کاری به شرح جدول زیر است:
            </p>
        </div>

        <div class="overflow-x-auto rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xl">
            <table class="w-full text-right text-xs sm:text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white font-black border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="p-4 sm:p-5">نوع مصنوع زینتی طلا</th>
                        <th class="p-4 sm:p-5 text-amber-500">محدوده درصد اجرت رایج</th>
                        <th class="p-4 sm:p-5">میزان کارمزد و سختی کار</th>
                        <th class="p-4 sm:p-5">توضیحات فنی و دلیل تفاوت نرخ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold">النگو شرکتی و ماشینی</td>
                        <td class="p-4 sm:p-5 text-amber-600 dark:text-amber-400 font-bold">۸٪ تا ۱۴٪</td>
                        <td class="p-4 sm:p-5">پایین (تولید انبوه تمام‌اتوماتیک)</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">به دلیل تولید قالبی در تیراژ بالا، کمترین هدررفت و اجرت را در میان مصنوعات دارد.</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold">زنجیر، دستبند کارگاهی و کارتیه</td>
                        <td class="p-4 sm:p-5 text-amber-600 dark:text-amber-400 font-bold">۱۰٪ تا ۱۶٪</td>
                        <td class="p-4 sm:p-5">متوسط</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">بستگی به بافت دستی یا ماشینی دانه‌ها و ظرافت قفل‌ها و اتصالات دارد.</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold">سرویس و نیم‌ست تراش (بدون نگین)</td>
                        <td class="p-4 sm:p-5 text-amber-600 dark:text-amber-400 font-bold">۱۵٪ تا ۲۲٪</td>
                        <td class="p-4 sm:p-5">بالا (تراش سی‌ان‌سی و لیزری)</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">پرت و براده‌برداری زیاد در دستگاه‌های تراش الماسه باعث بالا رفتن اجرت ساخت می‌شود.</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold">سرویس‌های نگین‌دار و پایه‌جواهر</td>
                        <td class="p-4 sm:p-5 text-amber-600 dark:text-amber-400 font-bold">۲۰٪ تا ۳۰٪</td>
                        <td class="p-4 sm:p-5">بسیار بالا (مخراج‌کاری دستی)</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">دستمزد مخراج‌کار برای سوار کردن اتمی یا برلیان و کسر وزن نگین در فاکتور محاسبه می‌گردد.</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold">طلای سبک مینیمال و لیزری (زیر ۲ گرم)</td>
                        <td class="p-4 sm:p-5 text-amber-600 dark:text-amber-400 font-bold">۱۸٪ تا ۲۸٪</td>
                        <td class="p-4 sm:p-5">فوق‌العاده ظریف</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">به علت وزن ناچیز کار، هزینه طراحی و برش لیزری سهم بالایی از کل قیمت را تشکیل می‌دهد.</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition-colors">
                        <td class="p-4 sm:p-5 font-bold">طلای کم‌اجرت و بدون اجرت (کارکرده)</td>
                        <td class="p-4 sm:p-5 text-emerald-600 dark:text-emerald-400 font-bold">۰٪ تا ۵٪</td>
                        <td class="p-4 sm:p-5">فاقد اجرت کارگاهی</td>
                        <td class="p-4 sm:p-5 text-slate-500 dark:text-slate-400 text-xs">طلای مستعمل شسته‌شده که فقط سود جزئی فروشنده بر نرخ خام اعمال می‌گردد.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p class="text-[11px] text-slate-500 dark:text-slate-400 text-center">
            * TODO(data): تأیید ارقام با اتحادیه طلا و جواهر. ارقام جدول فوق بر اساس میانگین کارگاه‌های تولیدی کشور در شهریور ۱۴۰۵ تنظیم گردیده است.
        </p>
    </section>

    {{-- بنر فراخوان میانی --}}
    @include('partials.cta-inline', [
        'title' => 'تابلوی هوشمند طلالایو؛ فرمول‌ساز خودکار اجرت و سود برای تلویزیون مغازه',
        'subtitle' => 'دیگر نیازی به ماشین‌حساب دستی پشت ویترین نیست. با فرمول‌ساز پیشرفته طلالایو، قیمت لحظه‌ای مصنوعات با اجرت و سود اختصاصی گالری شما روی تلویزیون نمایش داده می‌شود.',
        'buttonText' => 'تست رایگان ۱۴ روزه تابلوی ویترین',
        'buttonUrl' => route('admin.register'),
        'secondaryText' => 'امکانات تابلوی هوشمند',
        'secondaryUrl' => route('public.smart-gold-board'),
    ])

    {{-- فرمول دقیق و راهنمای فاکتور --}}
    <section class="grid sm:grid-cols-2 gap-8 items-start">
        <div class="space-y-4 p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
            <h2 class="text-xl font-black text-slate-900 dark:text-white">
                فرمول دقیق محاسبه فاکتور طلا با اجرت و مالیات قانونی
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                طبق آخرین اصلاحیه قانون مالیات بر ارزش افزوده مصوب مجلس شورای اسلامی، <strong>اصل طلای خام ۱۸ عیار از پرداخت ۹٪ مالیات معاف است</strong>. بنابراین فاکتور استاندارد طلافروشی طبق این رابطه ریاضی تنظیم می‌شود:
            </p>
            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 font-mono text-xs text-amber-600 dark:text-amber-400 leading-loose" dir="ltr">
                1. Raw Gold = Weight × Rate18<br>
                2. Wage = Raw Gold × (Wage% / 100)<br>
                3. Profit = (Raw Gold + Wage) × 7%<br>
                4. VAT = (Wage + Profit) × 9%<br>
                5. Total = Raw Gold + Wage + Profit + VAT
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                برای مطالعه تحلیل حقوقی و جزئیات سقف سود مجاز طلافروشان می‌توانید مقاله تحلیلی <a href="{{ route('public.guides.show', 'goldsmith-legal-profit') }}" class="text-amber-500 font-bold hover:underline">سود قانونی طلافروشی چند درصد است؟</a> را بررسی کنید.
            </p>
        </div>

        <div class="space-y-4 p-6 sm:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-lg">
            <h2 class="text-xl font-black text-slate-900 dark:text-white">
                تفاوت اجرت درصدی و اجرت تومانی (مبلغ ثابت) در فاکتور
            </h2>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                در بازار طلا دو روش برای دریافت اجرت ساخت مرسوم است:
            </p>
            <ul class="space-y-3 text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                <li class="flex items-start gap-2">
                    <span class="text-amber-500 font-bold">۱. اجرت درصدی:</span>
                    <span>اجرت ساخت متناسب با قیمت روز طلا بالا و پایین می‌رود (مثلاً ۱۸٪ ارزش طلای خام). کارگاه‌های بزرگ النگو و زیورآلات شرکتی معمولاً از این مدل استفاده می‌کنند.</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-amber-500 font-bold">۲. اجرت تومانی (ثابت):</span>
                    <span>یک مبلغ ریالی مقطوع به ازای هر گرم دریافت می‌شود (مثلاً ۶۰۰,۰۰۰ تومان در هر گرم). با افزایش شدید قیمت طلا، این روش به سود خریدار است چون درصد مؤثر آن کاهش می‌یابد.</span>
                </li>
            </ul>
            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed pt-2 border-t border-slate-100 dark:border-slate-800">
                همچنین می‌توانید از ابزار <a href="{{ route('public.tools.gold-price') }}" class="text-amber-500 font-bold hover:underline">ماشین حساب محاسبه قیمت طلا با اجرت و مالیات</a> برای محاسبات جامع‌تر بهره بگیرید.
            </p>
        </div>
    </section>

    {{-- بخش مطالب و ابزارهای مرتبط --}}
    @include('partials.related-links', [
        'title' => 'ابزارها و راهنماهای مرتبط با قیمت‌گذاری و فاکتور طلا',
        'links' => [
            [
                'title' => 'ماشین‌حساب جامع قیمت طلا و فاکتور',
                'desc' => 'محاسبه آنلاین قیمت طلا در مغازه با فرمول رسمی اتحادیه و احتساب سود و مالیات.',
                'url' => route('public.tools.gold-price'),
            ],
            [
                'title' => 'سود قانونی طلافروشی چند درصد است؟',
                'desc' => 'بررسی بخشنامه رسمی اتحادیه پیرامون سقف سود ۷ درصدی و فرمول قانونی صدور فاکتور.',
                'url' => route('public.guides.show', 'goldsmith-legal-profit'),
            ],
            [
                'title' => 'محاسبه‌گر طلای آبشده و عیار شرطی',
                'desc' => 'تبدیل وزن و عیار ری‌گیری طلای آبشده به ارزش ریالی با مظنه تهران و مثقال.',
                'url' => route('public.tools.melted-gold'),
            ],
        ]
    ])

</div>
@endsection
