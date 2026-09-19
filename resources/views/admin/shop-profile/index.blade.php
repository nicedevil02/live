@extends('admin.layouts.app')

@section('title', 'اطلاعات فروشگاه و QR اختصاصی')

@section('content')
<div x-data="shopProfileManager()" class="space-y-6 max-w-6xl mx-auto pb-12">

    {{-- Toast Notification --}}
    <div x-show="toast.show" x-transition
         :class="toast.type === 'success'
             ? 'bg-emerald-950 text-emerald-300 border-emerald-800'
             : 'bg-rose-950 text-rose-300 border-rose-800'"
         class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-3 px-5 py-3 rounded-2xl shadow-2xl border text-sm font-semibold"
         style="display: none;">
        <span x-text="toast.message"></span>
    </div>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm">
        <div>
            <div class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-amber-500/15 border border-amber-500/30 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black">
                    <i data-lucide="store" class="w-5 h-5"></i>
                </div>
                <div>
                    <h2 class="text-xl font-black text-slate-900 dark:text-white">اطلاعات فروشگاه و QR اختصاصی</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">مدیریت نام گالری، شهر، راه‌های ارتباطی و تنظیم بارکد اسکن تلویزیون</p>
                </div>
            </div>
        </div>

        <button @click="saveProfile()" :disabled="isSaving"
                class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-sm shadow-xl shadow-amber-500/20 transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
            <template x-if="isSaving">
                <div class="w-4 h-4 border-2 border-slate-950 border-t-transparent rounded-full animate-spin"></div>
            </template>
            <template x-if="!isSaving">
                <i data-lucide="check" class="w-4 h-4"></i>
            </template>
            <span x-text="isSaving ? 'در حال ذخیره‌سازی...' : 'ذخیره و انتشار روی تابلو'"></span>
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        {{-- ستون راست: اطلاعات فروشگاه و انتخاب شهر --}}
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm space-y-5">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <i data-lucide="building-2" class="w-5 h-5 text-amber-500"></i>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">مشخصات و هویت گالری</h3>
                </div>

                {{-- نام طلافروشی --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <i data-lucide="type" class="w-4 h-4 text-slate-400"></i>
                        <span>نام گالری / طلافروشی (نمایش در هدر تابلو)</span>
                    </label>
                    <input type="text" x-model="form.shop_name" placeholder="مثال: گالری طلای بهمن"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 transition-shadow">
                </div>

                {{-- شهر گالری --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <i data-lucide="map-pin" class="w-4 h-4 text-rose-500"></i>
                        <span>شهر گالری (جهت سئوی محلی در گوگل و فوتر تابلو)</span>
                    </label>
                    <select x-model="form.city"
                            class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 transition-shadow cursor-pointer">
                        @php
                            $groupedCities = collect(config('cities', []))->groupBy('province');
                        @endphp
                        @foreach($groupedCities as $province => $cities)
                            <optgroup label="استان {{ $province }}">
                                @foreach($cities as $slug => $c)
                                    <option value="{{ $slug }}">
                                        {{ $province !== $c['name'] ? ($province . ' (' . $c['name'] . ')') : $c['name'] }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                        <option value="other">سایر شهرهای ایران</option>
                    </select>
                    <p class="text-[11px] text-slate-400">این شهر در هدر و فوتر تابلو (مثلاً «همدان (ملایر)») و لینک‌های سئوی محلی گوگل نمایش داده می‌شود.</p>
                </div>

                {{-- شماره تلفن --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <i data-lucide="phone" class="w-4 h-4 text-emerald-500"></i>
                        <span>شماره تلفن / همراه</span>
                    </label>
                    <input type="text" dir="ltr" x-model="form.phone" placeholder="09187009064"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 text-left font-mono">
                </div>

                {{-- شبکه‌های اجتماعی --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                            <i data-lucide="instagram" class="w-4 h-4 text-pink-500"></i>
                            <span>اینستاگرام</span>
                        </label>
                        <input type="text" dir="ltr" x-model="form.instagram" placeholder="@my_gold_gallery"
                               class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/40 text-left font-mono">
                    </div>
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                            <i data-lucide="message-circle" class="w-4 h-4 text-indigo-500"></i>
                            <span>روبیکا / ایتا / تلگرام</span>
                        </label>
                        <input type="text" dir="ltr" x-model="form.rubika" placeholder="@channel_id"
                               class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/40 text-left font-mono">
                    </div>
                </div>
            </div>
        </div>

        {{-- ستون چپ: تنظیم کد QR اختصاصی --}}
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 shadow-sm space-y-5">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <i data-lucide="qr-code" class="w-5 h-5 text-indigo-500"></i>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-100">تنظیم کد QR اختصاصی تلویزیون</h3>
                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    با وارد کردن لینک کانال یا پیج خود، کد QR اختصاصی در گوشه بالای تابلوی تلویزیون قرار می‌گیرد تا مشتریان با دوربین گوشی آن را اسکن کنند.
                </p>

                {{-- آدرس لینک QR --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <i data-lucide="link" class="w-4 h-4 text-slate-400"></i>
                        <span>لینک مقصد (URL کامل)</span>
                    </label>
                    <input type="text" dir="ltr" x-model="form.qr_link" placeholder="https://rubika.ir/my_channel"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40 text-left font-mono">
                </div>

                {{-- عنوان بالای QR --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <i data-lucide="tag" class="w-4 h-4 text-slate-400"></i>
                        <span>متن بالای کد QR</span>
                    </label>
                    <input type="text" x-model="form.qr_label" placeholder="مثال: کانال روبیکا / عضویت باشگاه مشتریان"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                </div>

                {{-- توضیح زیر QR --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-300">
                        <i data-lucide="align-right" class="w-4 h-4 text-slate-400"></i>
                        <span>توضیح زیر کد QR</span>
                    </label>
                    <input type="text" x-model="form.qr_desc" placeholder="مثال: اسکن جهت عضویت در کانال قیمت‌ها"
                           class="w-full bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/40">
                </div>

                {{-- پیش‌نمایش زنده در کارت تلویزیون --}}
                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200 dark:border-slate-700 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <span class="text-[10px] text-amber-500 font-bold uppercase tracking-wider block">پیش‌نمایش در تابلوی تلویزیون</span>
                        <p class="text-xs font-black text-slate-800 dark:text-slate-100 truncate mt-1" x-text="form.qr_label || 'عضویت در شبکه‌های اجتماعی'"></p>
                        <p class="text-[11px] text-slate-400 truncate mt-0.5" x-text="form.qr_desc || 'اسکن جهت مشاهده در موبایل'"></p>
                    </div>
                    <div class="w-14 h-14 bg-white p-1 rounded-xl shadow-xs shrink-0 flex items-center justify-center">
                        <img src="{{ asset('images/sample-qr.png') }}" onerror="this.src='/icons/icon-72x72.png'" class="w-full h-full object-contain" alt="QR">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
function shopProfileManager() {
    return {
        isSaving: false,
        toast: { show: false, message: '', type: 'success' },
        form: {
            shop_name: @json($settings->shop_name ?? $user->name ?? ''),
            city: @json(!empty($user->city_slug) ? $user->city_slug : ($settings->city_slug ?? 'tehran')),
            phone: @json($settings->phone ?? $user->phone ?? ''),
            instagram: @json($settings->instagram ?? ''),
            rubika: @json($settings->rubika ?? ''),
            qr_link: @json($settings->qr_link ?? ''),
            qr_label: @json($settings->qr_label ?? ''),
            qr_desc: @json($settings->qr_desc ?? '')
        },

        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => this.toast.show = false, 3500);
        },

        async saveProfile() {
            this.isSaving = true;
            try {
                const res = await fetch("{{ route('admin.shop-profile.update') }}", {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.form)
                });

                if (!res.ok) {
                    const err = await res.json().catch(() => ({}));
                    throw new Error(err.message || 'خطا در ذخیره‌سازی اطلاعات');
                }

                const data = await res.json();
                if (data.user && data.user.city_slug) {
                    this.form.city = data.user.city_slug;
                }
                this.showToast(data.message || 'اطلاعات فروشگاه با موفقیت ذخیره شد.', 'success');
            } catch (err) {
                this.showToast(err.message, 'error');
            } finally {
                this.isSaving = false;
            }
        }
    };
}
</script>
@endpush
