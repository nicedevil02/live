# TalaLive Public Design System (DESIGN.md)

## Direction (Apple HIG Spatial Glass + Tactile 18K Bullion Neumorphism)
1. **Domain & Audience:** سامانه ابری تابلوی نرخ لحظه‌ای طلا، سکه و ارز ویژه صاحبان گالری‌های طلا و جواهر و صرافی‌های ایران.
2. **Aesthetic Character:** تلفیق متریال شیشه‌ای زنده اپل (**Apple HIG Liquid Frosted Glass & Vibrancy**) در لایه‌های شناور با فیزیک حجم‌پردازی لمسی نئومورفیک (**135° Dual-Shadow Tactile Neumorphism**) روی بوم مرواریدی گرم و گرافیت نیمه‌شب؛ الهام‌گرفته از ویترین‌های جواهر، شمش طلای ۱۸ عیار صیقلی و ابزارهای دقیق ساعت‌سازی بدون گرادینت‌های بنفش/سایان هوش مصنوعی و بدون ایموجی.
3. **Color & Lighting Physics:** منبع نور زاویه `135°` (بالا-راست / بالا-چپ متقارن با هایلایت لبه‌ی فوقانی `Specular Top Rim`) روی بوم **مرواریدی گرم (`#F1EEE7`)** در تم روشن و **گرافیت ابسیدین (`#141312`)** در تم تیره، همراه با تک‌رنگ تاکیدی طلای ۱۸ عیار (`#B45309` روی سطوح روشن، `#FBBF24` روی سطوح تیره و شمش سه‌بعدی `#FCD34D -> #F59E0B -> #D97706` با جوهر تیره `#1C1917` برای دکمه‌های اصلی).
4. **Typography & Iconography:** فونت یکپارچه `Vazirmatn` با کف سایز استاندارد، اعداد هم‌عرض (`tabular-nums`) برای نمایشگرهای نرخ و ماشین‌حساب‌ها، و آیکون‌های برداری هندسی `1.5px` بدون ایموجی.
5. **Spatial & Motion Dials:** `Dial: ENERGY 2 (Balanced Luxury) / RHYTHM 2 (Measured Studio Variation) / MOTION 2 (Apple Spring Physics cubic-bezier(0.22, 1, 0.36, 1), 60fps GPU-safe, reduced-motion compliant)`.

## Semantic Color & Lighting Tokens (WCAG AA Mathematically Verified >= 4.5:1)

| Token | Light Mode (`Warm Alabaster Pearl`) | Dark Mode (`Midnight Obsidian Graphite`) | Contrast / Physics Role |
| :--- | :--- | :--- | :--- |
| `--tl-bg` | `#F1EEE7` | `#141312` | Sculpted Neumorphic base canvas |
| `--tl-surface` | `#F8F6F1` (`#FBF9F5 -> #EFECE4`) | `#1D1B19` (`#221F1D -> #171514`) | Raised convex Neumorphic card surface |
| `--tl-inset-bg` | `#E6E1D6` | `#0D0C0B` | Carved concave well for inputs & tracks |
| `--tl-glass-bg` | `rgba(255, 255, 255, 0.74)` | `rgba(24, 22, 20, 0.76)` | `blur(24px) saturate(190%)` Apple Vibrancy |
| `--tl-text` | `#1C1917` (`stone-900`) | `#FAFAF9` (`stone-50`) | `15.09:1` (Light) / `17.6:1` (Dark) |
| `--tl-text-secondary` | `#44403C` (`stone-700`) | `#D6D3D1` (`stone-300`) | `8.4:1` (Light) / `11.1:1` (Dark) |
| `--tl-text-muted` | `#57534E` (`stone-600`) | `#A8A29E` (`stone-400`) | `5.85:1` on inset `#E6E1D6` / `6.81:1` on dark card |
| `--tl-accent-text` | `#B45309` (`amber-700`) | `#FBBF24` (`amber-400`) | `4.61:1` on `#F7F5F0` / `10.29:1` on `#1D1B19` |
| `--tl-bullion-cta` | `#FCD34D -> #F59E0B -> #D97706` | `#FCD34D -> #F59E0B -> #D97706` | `#1C1917` ink = `5.49:1` at darkest stop (`8.1:1` mid) |

## Owner-Directed Overrides & Purpose-Gate Reason Log (R-31 / R-37)
طبق دستور مستقیم مالک محصول (`2026-11-01`، انتخاب گزینه ۱: ترکیب Apple HIG + Neumorphic Soft UI):
- **Apple HIG Liquid Frosted Glass (`R-10` / `R-30` Owner Override):** استفاده هدفمند از شیشه مات زنده (`backdrop-filter: blur(22px-24px) saturate(185%-190%)` همراه با هایلایت لبه‌ی فوقانی ۱ پیکسلی) صرفاً در لایه‌های شناور شامل هدر کپسولی هوشمند بالا، منوهای بازشوی ناوبری، دراور موبایل، مودال‌ها و پنل شاخص تبدیل هیرو؛ کارت‌های در حال اسکرول از شیشه بلر استفاده نمی‌کنند تا نرخ فریم `60fps` موبایل و تفکیک سلسله‌مراتب حفظ شود.
- **135° Dual-Shadow Neumorphic Elevation & Concave Wells (`R-12` Owner Override):** استفاده از سایه دوگانه فیزیکی (نور بالا-چپ + سایه عمق پایین-راست + مرز میکرو-بِوِل) برای تفکیک ملموس سه سطح ارتفاعی: ۱) کارت‌ها و دکمه‌های برجسته (`Convex Raised`)، ۲) فیلدهای ورودی، ریل تب‌ها و شیار ماشین‌حساب‌ها (`Concave Inset`)، و ۳) نمایشگر تیره فاکتور نهایی (`OLED Bullion Readout`).
- **Warm 18K Gold Studio Bias Lighting (`R-13` Owner Override):** هاله نور مخفی طلایی ۱۸ عیار صرفاً در پشت قاب تیتانیومی تلویزیون ۶۵ اینچ در هیرو و پنل ورود (شبیه‌سازی نور مخفی دیوار گالری طلافروشی) و درخشش لبه‌ی دکمه اصلی به کار می‌رود.
- **Single Live Status Indicator & Apple Spring Motion (`R-19`):** نشانگر زنده بازار برای نمایش اتصال لحظه‌ای فید قیمت و منحنی فنری اپل (`cubic-bezier(0.22, 1, 0.36, 1)`) برای بازخورد لمسی طبیعی به کار می‌روند و هر دو با `prefers-reduced-motion: reduce` متوقف می‌شوند.

## Owner-Verified Claims Log (R-36 / R-37)
موارد زیر در تاریخ `2026-11-01` توسط مالک کسب‌وکار تایید و مستند شده‌اند:
1. `+۳۵۰` گالری فعال در سراسر کشور (`resources/views/pages/about.blade.php` و `resources/views/pages/smart-gold-board.blade.php`).
2. `ضمانت بازگشت وجه در صورت عدم رضایت` (`resources/views/pages/pricing.blade.php`).
3. `نرخ در دسترس‌پذیری ۹۹.۹٪` (`resources/views/pages/terms.blade.php`).
