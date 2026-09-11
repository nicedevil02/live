@extends('admin.layouts.app')

@section('title', 'تنظیمات پوسته و نمایش')

@section('content')
<div x-data="displayControlPage()" x-init="init(@js($settings), @js($items))" class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-xl">
                <i data-lucide="monitor" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100">تنظیمات تابلو نمایش</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                    پوسته بصری، اطلاعات فروشگاه، سرعت اسلایدر و کاشی‌های قیمت
                    <span x-show="settings.published_at" class="mr-3 text-emerald-600 dark:text-emerald-400">
                        · آخرین انتشار: <span x-text="new Date(settings.published_at).toLocaleString('fa-IR')"></span>
                    </span>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-700 dark:text-slate-300 px-4 py-2.5 rounded-xl font-semibold transition-colors text-sm cursor-pointer">
                انصراف
            </a>
            <button @click="saveSettings()" :disabled="isSaving"
                    class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl font-semibold transition-all disabled:opacity-50 shadow-sm shadow-emerald-500/20 text-sm cursor-pointer">
                <i x-show="!isSaving" data-lucide="save" class="w-4 h-4"></i>
                <span x-text="isSaving ? 'در حال ذخیره...' : 'ذخیره تنظیمات'"></span>
            </button>
            <button @click="publish()" :disabled="isPublishing"
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-colors disabled:opacity-50 shadow-sm shadow-blue-500/20 text-sm cursor-pointer">
                <i x-show="!isPublishing" data-lucide="send" class="w-4 h-4"></i> <span x-text="isPublishing ? 'در حال انتشار...' : 'انتشار روی تابلو'"></span>
            </button>
        </div>
    </div>

    {{-- Feedback --}}
    <div x-show="message.text" x-transition
         :class="message.type === 'success' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50' : 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800/50'"
         class="flex items-center gap-2 px-4 py-3 rounded-xl border text-sm font-semibold">
        <i x-show="message.type === 'success'" data-lucide="check-circle-2" class="w-5 h-5"></i>
        <i x-show="message.type !== 'success'" data-lucide="alert-circle" class="w-5 h-5"></i>
        <span x-text="message.text"></span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full">
        {{-- Left Column: Theme & Settings --}}
        <div class="lg:col-span-7 space-y-6">
            {{-- Theme Selector --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-5">
                    <i data-lucide="palette" class="w-5 h-5 text-violet-500"></i>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">انتخاب پوسته نمایشگر</h3>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-2 gap-3">
                    <template x-for="theme in THEME_OPTIONS" :key="theme.id">
                        <label class="relative flex flex-col gap-2 p-3 rounded-xl border-2 cursor-pointer transition-all duration-200"
                               :class="settings.theme_mode === theme.id
                                   ? 'border-indigo-500 ring-2 ring-indigo-500/20 bg-indigo-50 dark:bg-indigo-900/10'
                                   : 'border-slate-200 dark:border-slate-700 hover:border-indigo-300 dark:hover:border-indigo-700 hover:bg-slate-50 dark:hover:bg-slate-800/50'">
                            <input type="radio" name="theme" class="sr-only" :checked="settings.theme_mode === theme.id"
                                   @change="settings.theme_mode = theme.id">
                            <div class="w-full h-12 rounded-lg border-2 flex items-center justify-center gap-2" :class="theme.preview">
                                <div class="w-3 h-3 rounded-full" :class="theme.dot"></div>
                                <div class="w-6 h-1.5 rounded-full opacity-50" :class="theme.dot"></div>
                                <div class="w-2 h-2 rounded-full opacity-30" :class="theme.dot"></div>
                            </div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <div class="w-3.5 h-3.5 rounded-full border-2 flex items-center justify-center shrink-0"
                                     :class="settings.theme_mode === theme.id ? 'border-indigo-500' : 'border-slate-300 dark:border-slate-600'">
                                    <div x-show="settings.theme_mode === theme.id" class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                </div>
                                <span class="font-bold text-sm text-slate-800 dark:text-slate-200 truncate" x-text="theme.name"></span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed pr-5" x-text="theme.desc"></p>
                        </label>
                    </template>
                </div>
            </div>

            {{-- Shop Info & Timing --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Shop Info --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100 mb-4">اطلاعات فروشگاه</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-600 dark:text-slate-400 mb-1.5"><i data-lucide="type" class="w-4 h-4"></i> عنوان</label>
                            <input type="text" x-model="settings.shop_name" placeholder="مثال: گالری طلای سجاد"
                                   class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40 transition-shadow">
                        </div>
                        <div>
                            <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-600 dark:text-slate-400 mb-1.5"><i data-lucide="phone" class="w-4 h-4"></i> تلفن</label>
                            <input type="text" dir="ltr" x-model="settings.phone" placeholder="021-xxxxxxxx"
                                   class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40 text-left">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-600 dark:text-slate-400 mb-1.5"><i data-lucide="instagram" class="w-4 h-4"></i> اینستاگرام</label>
                                <input type="text" dir="ltr" x-model="settings.instagram" placeholder="@page"
                                       class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40 text-left">
                            </div>
                            <div>
                                <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-600 dark:text-slate-400 mb-1.5"><i data-lucide="message-circle" class="w-4 h-4"></i> روبیکا</label>
                                <input type="text" dir="ltr" x-model="settings.rubika" placeholder="@channel"
                                       class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40 text-left">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Slider Timing --}}
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center gap-2 mb-4">
                        <i data-lucide="clock" class="w-5 h-5 text-amber-500"></i>
                        <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">زمان‌بندی اسلایدر</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <template x-for="opt in [{val:5, label:'۵ ثانیه', sub:'سریع'},{val:8, label:'۸ ثانیه', sub:'متوسط'},{val:12, label:'۱۲ ثانیه', sub:'آرام'},{val:20, label:'۲۰ ثانیه', sub:'خیلی آرام'}]" :key="opt.val">
                            <button @click="settings.slider_interval_sec = opt.val"
                                    class="flex flex-col items-center gap-1 py-3 rounded-xl border-2 transition-all text-sm font-semibold"
                                    :class="settings.slider_interval_sec === opt.val
                                        ? 'border-amber-500 bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400'
                                        : 'border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:border-amber-300'">
                                <span x-text="opt.label"></span>
                                <span class="text-[10px] font-normal" :class="settings.slider_interval_sec === opt.val ? 'text-amber-500' : 'text-slate-400'" x-text="opt.sub"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            {{-- QR Code Setting --}}
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                <div class="flex items-center gap-2 mb-4">
                    <i data-lucide="qr-code" class="w-5 h-5 text-indigo-500"></i>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">تنظیم کد QR اختصاصی (لینک دعوت یا وب‌سایت)</h3>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mb-4 leading-relaxed">
                    می‌توانید لینک دعوت کانال ایتا، روبیکا، تلگرام یا آدرس وب‌سایت خود را اینجا وارد کنید. این لینک به شکل یک کد QR در سربرگ تلویزیون نمایش داده می‌شود تا مشتریان بتوانند با اسکن آن عضو شوند.
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-600 dark:text-slate-400 mb-1.5"><i data-lucide="link" class="w-4 h-4"></i> لینک دعوت / آدرس (URL)</label>
                        <input type="text" dir="ltr" x-model="settings.qr_link" placeholder="https://rubika.ir/my_channel"
                               class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40 text-left">
                    </div>
                    <div>
                        <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-600 dark:text-slate-400 mb-1.5"><i data-lucide="tag" class="w-4 h-4"></i> عنوان کد QR (بالا)</label>
                        <input type="text" x-model="settings.qr_label" placeholder="مثال: نوبت‌دهی آنلاین / پشتیبانی روبیکا"
                               class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                    </div>
                    <div>
                        <label class="flex items-center gap-1.5 text-sm font-semibold text-slate-600 dark:text-slate-400 mb-1.5"><i data-lucide="tag" class="w-4 h-4"></i> توضیح زیر کد QR (پایین)</label>
                        <input type="text" x-model="settings.qr_desc" placeholder="مثال: عضویت در شبکه‌های اجتماعی"
                               class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Display Items Toggles --}}
        <div class="lg:col-span-5">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl shadow-sm h-full flex flex-col">
                <div class="p-6 border-b border-slate-200 dark:border-slate-800">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <i data-lucide="layout-grid" class="w-5 h-5 text-emerald-500"></i>
                            <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">کاشی‌های قیمت (نمایشگر)</h3>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-xs font-semibold text-slate-500"
                              x-text="items.filter(i => i.enabled).length + ' فعال'"></span>
                    </div>
                    <p class="text-sm text-slate-500 mt-2 leading-relaxed">اقلامی که می‌خواهید روی تابلو نمایش داده شوند را فعال کنید. برای اعمال تغییرات، دکمه ذخیره و انتشار را بزنید.</p>
                </div>
                <div class="p-4 flex-1 overflow-y-auto max-h-[600px] custom-scrollbar">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-2">
                        <template x-for="(item, index) in items" :key="item.key">
                            <label class="flex items-center justify-between p-3 rounded-xl border transition-colors cursor-pointer select-none"
                                   :class="item.enabled
                                       ? 'bg-slate-50 dark:bg-slate-800/60 border-slate-300 dark:border-slate-600'
                                       : 'bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-800 opacity-60 hover:opacity-100'">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-mono text-slate-400 w-4 text-center" x-text="index + 1"></span>
                                    <span class="text-sm font-bold" :class="item.enabled ? 'text-slate-800 dark:text-slate-200' : 'text-slate-500'" x-text="item.label"></span>
                                </div>
                                <div class="relative inline-flex h-5 w-9 shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none"
                                     @click="item.enabled = !item.enabled">
                                    <div class="h-5 w-9 rounded-full transition-colors" :class="item.enabled ? 'bg-emerald-500' : 'bg-slate-200 dark:bg-slate-700'"></div>
                                    <div class="absolute left-[2px] top-[2px] h-4 w-4 rounded-full bg-white transition-transform" :class="item.enabled ? 'translate-x-4' : ''"></div>
                                </div>
                            </label>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Actions --}}
    <div class="flex justify-end gap-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm">
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-2 bg-slate-100 dark:bg-slate-850 hover:bg-slate-200 text-slate-700 dark:text-slate-300 px-6 py-3 rounded-xl font-bold transition-colors text-sm cursor-pointer">
            انصراف
        </a>
        <button @click="saveSettings()" :disabled="isSaving"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition-all disabled:opacity-50 shadow-md shadow-blue-500/20 text-sm cursor-pointer">
            <i x-show="!isSaving" data-lucide="save" class="w-4 h-4"></i>
            <span x-text="isSaving ? 'در حال ذخیره...' : 'ذخیره تنظیمات'"></span>
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
function displayControlPage() {
    return {
        settings: { theme_mode: 'dark-glass', slider_interval_sec: 8, show_weight: true, show_labor: true, show_profit: true, shop_name: '', phone: '', instagram: '', rubika: '', qr_link: '', qr_label: '', qr_desc: '', published_at: null },
        items: [],
        message: { text: '', type: '' },
        isSaving: false,
        isPublishing: false,

        THEME_OPTIONS: [
            { id: 'dark-glass', name: 'تاریک شیشه‌ای', desc: 'پس‌زمینه تیره با افکت بلور', preview: 'bg-slate-900 border-slate-700', dot: 'bg-blue-500' },
            { id: 'light-modern', name: 'روشن مدرن', desc: 'سفید و پاکیزه با کنتراست بالا', preview: 'bg-white border-slate-200', dot: 'bg-blue-600' },
            { id: 'gold-royal', name: 'طلایی سلطنتی', desc: 'پس‌زمینه قهوه‌ای با رنگ طلایی', preview: 'bg-amber-950 border-amber-800', dot: 'bg-amber-400' },
            { id: 'blue-ocean', name: 'آبی اقیانوسی', desc: 'آبی تیره، درخشش فیروزه‌ای', preview: 'bg-indigo-950 border-blue-800', dot: 'bg-cyan-400' },
            { id: 'purple-haze', name: 'بنفش مه‌آلود', desc: 'بنفش تیره با تأثیر رمزآلود', preview: 'bg-purple-950 border-purple-800', dot: 'bg-violet-400' },
            { id: 'emerald-night', name: 'سبز شب', desc: 'سبز تیره، حس فناوری', preview: 'bg-emerald-950 border-emerald-800', dot: 'bg-emerald-400' },
            { id: 'rose-dark', name: 'رز تیره', desc: 'قرمز تیره، زیبایی خاص', preview: 'bg-rose-950 border-rose-900', dot: 'bg-rose-400' },
            { id: 'imperial-onyx', name: 'اونیکس شاهنشاهی ۲۴ عیار (VIP)', desc: 'شاهکار لوکس موناکو، لبه‌های براق طلای ۲۴ عیار و نورپردازی کهربایی', preview: 'bg-gradient-to-br from-slate-950 via-zinc-950 to-amber-950 border-amber-400 shadow-md', dot: 'bg-amber-400' },
            { id: 'pure-black', name: 'خالص مشکی', desc: 'پس‌زمینه کاملا مشکی و مینیمال', preview: 'bg-black border-slate-800', dot: 'bg-zinc-400' },
            { id: 'bing-daily', name: 'عکس بینگ: شیشه ابسیدین (پیشنهادی)', desc: 'شیشه دودی تیتانیوم اپل با لبه طلایی ۲۴ عیار', preview: 'bg-gradient-to-br from-slate-950 via-slate-900 to-amber-950 border-amber-500/50', dot: 'bg-amber-400' },
            { id: 'bing-studio', name: 'عکس بینگ: استودیو شیشه‌ای', desc: 'استیج یکپارچه مات اپل با وقار و خوانایی بالا', preview: 'bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-950 border-indigo-500/40', dot: 'bg-indigo-400' },
            { id: 'bing-ceramic', name: 'عکس بینگ: پرسلین سفید', desc: 'سرامیک سفید براق اپل، بدون شلوغی پس‌زمینه', preview: 'bg-gradient-to-br from-white via-slate-100 to-slate-200 border-slate-300', dot: 'bg-slate-700' },
        ],

        init(settingsData, itemsData) {
            if (settingsData) this.settings = { ...this.settings, ...settingsData };
            if (itemsData) this.items = itemsData.sort((a,b) => a.order - b.order);
        },

        showMessage(text, type = 'success') {
            this.message = { text, type };
            setTimeout(() => this.message = { text: '', type: '' }, 3500);
        },

        async saveSettings() {
            this.isSaving = true;
            try {
                const [settingsRes, itemsRes] = await Promise.all([
                    fetch('/admin/display-settings', {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify(this.settings)
                    }),
                    fetch('/admin/display-items', {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ items: this.items })
                    })
                ]);
                const savedSettings = await settingsRes.json();
                const savedItems = await itemsRes.json();
                this.settings = { ...this.settings, ...savedSettings };
                this.items = savedItems.sort((a,b) => a.order - b.order);
                this.showMessage('تنظیمات با موفقیت ذخیره شد.', 'success');
            } catch (e) {
                this.showMessage(e.message || 'خطا در ذخیره', 'error');
            } finally {
                this.isSaving = false;
            }
        },

        async publish() {
            this.isPublishing = true;
            try {
                // ذخیره اول
                const [settingsRes, itemsRes] = await Promise.all([
                    fetch('/admin/display-settings', {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify(this.settings)
                    }),
                    fetch('/admin/display-items', {
                        method: 'PUT',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ items: this.items })
                    })
                ]);
                const saveSettings = await settingsRes.json();
                this.settings = { ...this.settings, ...saveSettings };

                // انتشار
                const publishRes = await fetch('/admin/publish', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });
                const publishData = await publishRes.json();
                this.showMessage(publishData.message, 'success');
                this.settings.published_at = publishData.published_at;

                const savedItems = await itemsRes.json();
                this.items = savedItems.sort((a,b) => a.order - b.order);
            } catch (e) {
                this.showMessage(e.message || 'خطا در انتشار', 'error');
            } finally {
                this.isPublishing = false;
            }
        }
    };
}
</script>
@endpush
