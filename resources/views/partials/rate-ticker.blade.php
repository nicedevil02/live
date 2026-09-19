{{-- نوار نرخ زنده لحظه‌ای زیر هدر (H-20) --}}
<div x-data="rateTicker()" 
     x-init="load()"
     data-endpoint="{{ route('api.display.snapshot', ['username' => 'admin'], false) }}"
     class="h-9 border-b border-slate-200/70 dark:border-slate-800/70 bg-white/90 dark:bg-slate-950/90 overflow-hidden select-none"
     aria-label="نوار نرخ زنده بازار طلا و ارز">
    <div class="max-w-7xl mx-auto px-2.5 sm:px-6 lg:px-8 h-9 flex items-center gap-4 overflow-x-auto snap-x scrollbar-none transition-opacity duration-300"
         :class="stale ? 'opacity-60 grayscale' : ''">
        <template x-if="!loaded">
            <div class="flex items-center gap-4 w-full" aria-hidden="true">
                <div class="h-3 w-28 rounded-full bg-slate-200 dark:bg-slate-800 animate-pulse"></div>
                <div class="h-3 w-28 rounded-full bg-slate-200 dark:bg-slate-800 animate-pulse"></div>
                <div class="h-3 w-28 rounded-full bg-slate-200 dark:bg-slate-800 animate-pulse"></div>
                <div class="h-3 w-24 rounded-full bg-slate-200 dark:bg-slate-800 animate-pulse"></div>
                <div class="h-2.5 w-16 rounded-full bg-slate-200 dark:bg-slate-800 mr-auto animate-pulse"></div>
            </div>
        </template>
        <template x-if="loaded">
            <div class="flex items-center gap-4 text-[11px] sm:text-xs whitespace-nowrap w-full">
                <template x-for="row in items" :key="row.key">
                    <span class="flex items-center gap-1.5 snap-start shrink-0">
                        <span class="text-slate-500 dark:text-slate-400 font-medium" x-text="row.label"></span>
                        <span class="font-bold text-slate-800 dark:text-slate-100 font-mono tracking-tight" x-text="row.price"></span>
                        <span :class="row.dir === 'up' ? 'text-emerald-500' : (row.dir === 'down' ? 'text-red-500' : 'text-slate-400')"
                              :title="row.dir === 'up' ? 'افزایشی' : (row.dir === 'down' ? 'کاهشی' : 'بدون تغییر')"
                              x-text="row.dir === 'up' ? '▲' : (row.dir === 'down' ? '▼' : '–')"></span>
                    </span>
                </template>
                <span class="text-[10px] text-slate-400 mr-auto shrink-0 transition-colors"
                      :class="stale ? 'text-amber-500 dark:text-amber-400 font-bold' : 'text-slate-400'"
                      x-text="stale ? 'تأخیر در به‌روزرسانی' : updatedLabel"></span>
            </div>
        </template>
    </div>
</div>

@push('scripts')
<script>
function rateTicker() {
    return {
        endpoint: '',
        loaded: false,
        stale: false,
        items: [],
        updatedLabel: '',
        timer: null,

        init() {
            this.endpoint = this.$el.dataset.endpoint || '';
        },

        async load() {
            if (!this.endpoint) {
                this.endpoint = this.$el.dataset.endpoint || '';
            }
            try {
                const res = await fetch(this.endpoint, { 
                    headers: { 'Accept': 'application/json' },
                    cache: 'no-store'
                });
                if (!res.ok) throw new Error('bad status ' + res.status);
                const data = await res.json();
                
                const mapped = this.mapRows(data);
                if (mapped.length > 0) {
                    this.items = mapped;
                }
                this.stale = Boolean(data.isStale);
                this.updatedLabel = this.formatAge(data.dataAgeSeconds);
                this.loaded = true;
            } catch (e) {
                // خطا را بلع نکن: نوار در حالت کهنه با پیام تأخیر باقی می‌ماند
                this.stale = true;
                this.loaded = true;
            }
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.load(), 120000);
        },

        mapRows(data) {
            if (!data || !Array.isArray(data.priceFeed)) return [];
            
            const targetOrder = [
                { key: 'mesghal17', defaultLabel: 'مظنه مثقال' },
                { key: 'gold18', defaultLabel: 'طلای ۱۸ عیار' },
                { key: 'coin_emami', defaultLabel: 'سکه امامی' },
                { key: 'usd', defaultLabel: 'دلار' }
            ];

            const feedMap = {};
            data.priceFeed.forEach(item => {
                if (item && item.symbol) {
                    feedMap[item.symbol] = item;
                }
            });

            return targetOrder.map(target => {
                const item = feedMap[target.key];
                if (!item) return null;
                const formattedPrice = (Number(item.value) || 0).toLocaleString('fa-IR');
                const unit = item.unit ? (' ' + item.unit) : ' تومان';
                return {
                    key: target.key,
                    label: item.label || target.defaultLabel,
                    price: formattedPrice + unit,
                    dir: item.direction || 'flat'
                };
            }).filter(Boolean);
        },

        formatAge(ageSec) {
            if (ageSec === null || ageSec === undefined || ageSec < 60) {
                return 'چند لحظه پیش';
            }
            const minutes = Math.floor(ageSec / 60);
            if (minutes <= 1) {
                return '۱ دقیقه پیش';
            }
            if (minutes < 60) {
                return minutes.toLocaleString('fa-IR') + ' دقیقه پیش';
            }
            const hours = Math.floor(minutes / 60);
            return hours.toLocaleString('fa-IR') + ' ساعت پیش';
        }
    };
}
</script>
@endpush
