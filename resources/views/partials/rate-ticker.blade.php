{{-- کامپوننت نوار نرخ زنده لحظه‌ای (H-20) --}}
<div x-data="rateTicker()" 
     x-init="load()"
     data-endpoint="{{ route('api.market.ticker', [], false) }}"
     class="flex items-center gap-3 sm:gap-4 select-none min-w-0"
     aria-label="نوار نرخ زنده بازار طلا و ارز">
    <div class="flex items-center gap-3 sm:gap-4 transition-opacity duration-300"
         :class="stale ? 'opacity-60 grayscale' : ''">
        <template x-if="!loaded">
            <div class="flex items-center gap-3 w-full" aria-hidden="true">
                <div class="h-2.5 w-24 rounded-full bg-stone-200 dark:bg-stone-800 animate-pulse"></div>
                <div class="h-2.5 w-24 rounded-full bg-stone-200 dark:bg-stone-800 animate-pulse"></div>
                <div class="h-2.5 w-24 rounded-full bg-stone-200 dark:bg-stone-800 animate-pulse"></div>
                <div class="h-2.5 w-20 rounded-full bg-stone-200 dark:bg-stone-800 animate-pulse"></div>
            </div>
        </template>
        <template x-if="loaded">
            <div class="flex items-center gap-3 sm:gap-4 text-xs whitespace-nowrap">
                <span class="inline-flex h-2 w-2 rounded-full shrink-0 tl-live-dot"
                      :class="stale ? 'bg-amber-500' : 'bg-emerald-500'"
                      aria-hidden="true"></span>
                <template x-for="row in items" :key="row.key">
                    <span class="flex items-center gap-1.5 snap-start shrink-0">
                        <span class="text-stone-600 dark:text-stone-400 font-medium" x-text="row.label"></span>
                        <span class="font-bold text-stone-900 dark:text-stone-100 tabular-nums" x-text="row.price"></span>
                        <span :class="row.dir === 'up' ? 'text-emerald-700 dark:text-emerald-400' : (row.dir === 'down' ? 'text-rose-700 dark:text-rose-400' : 'text-stone-400 dark:text-stone-500')"
                              :title="row.dir === 'up' ? 'افزایشی' : (row.dir === 'down' ? 'کاهشی' : 'بدون تغییر')"
                              x-text="row.dir === 'up' ? '▲' : (row.dir === 'down' ? '▼' : '-')"></span>
                    </span>
                </template>
                <span class="text-xs shrink-0 transition-colors"
                      :class="stale ? 'text-amber-800 dark:text-amber-400 font-semibold' : 'text-stone-500 dark:text-stone-400'"
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
                this.stale = true;
                this.loaded = true;
            }
            clearTimeout(this.timer);
            this.timer = setTimeout(() => this.load(), 10000);
        },

        mapRows(data) {
            if (!data || !Array.isArray(data.priceFeed)) return [];
            
            const targetOrder = [
                { key: 'mesghal17', defaultLabel: 'آبشده' },
                { key: 'gold18', defaultLabel: 'طلای ۱۸ عیار' },
                { key: 'coin_emami', defaultLabel: 'سکه امامی' },
                { key: 'usdt', defaultLabel: 'تتر (دلار دیجیتال)' }
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
                const numVal = Number(item.value) || 0;
                let priceText = 'در حال به‌روزرسانی';
                if (numVal > 0) {
                    const formattedPrice = numVal.toLocaleString('fa-IR');
                    const unit = item.unit ? (' ' + item.unit) : ' تومان';
                    priceText = formattedPrice + unit;
                }
                return {
                    key: target.key,
                    label: item.label || target.defaultLabel,
                    price: priceText,
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
