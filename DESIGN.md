# TalaLive Public Design System (DESIGN.md)

## Direction (Unslop 5-Line North Star)
1. **Domain & Audience:** سامانه ابری تابلوی نرخ لحظه‌ای طلا، سکه و ارز ویژه صاحبان گالری‌های طلا و جواهر و صرافی‌های ایران.
2. **Aesthetic Character:** معماری دقیق و سنگین ویترین طلافروشی (Warm Architectural Stone & 18K Bullion Gold)؛ بدون زرق‌وبرق نئونی، بدون گرادینت‌های بنفش/آبی هوش مصنوعی و بدون تقلید از اپل.
3. **Color Physics:** پالت خنثای گرم سنگی (`stone-50` تا `stone-950`) در هر دو تم روشن و تیره، همراه با تک‌رنگ تاکیدی طلای ۱۸ عیار خوانا (`#b45309` روی سطوح روشن، `#fbbf24` روی سطوح تیره، `#f59e0b` با متن تیره `#1c1917` برای دکمه اصلی).
4. **Typography & Iconography:** فونت یکپارچه `Vazirmatn` با کف سایز `12px` (`text-xs`)، سلسله‌مراتب وزن کنترل‌شده (`400/500/600/700`)، اعداد هم‌عرض (`tabular-nums`) برای نرخ‌ها و آیکون‌های خطی هندسی `1.5px` بدون ایموجی.
5. **Spatial & Motion Dials:** `ENERGY: 2 (Balanced)` | `RHYTHM: 2 (Measured variation)` | `MOTION: 1 (Calm, functional 150ms color/border transitions, zero hover-scale, reduced-motion safe)`.

## Semantic Color Tokens (WCAG AA Verified >= 4.5:1)

| Token | Light Mode (`Warm Stone`) | Dark Mode (`Warm Graphite`) | Contrast Verification |
| :--- | :--- | :--- | :--- |
| `--tl-bg` | `#fafaf9` (`stone-50`) | `#0c0a09` (`stone-950`) | Page canvas |
| `--tl-surface` | `#ffffff` (`white`) | `#1c1917` (`stone-900`) | Elevated card / panel |
| `--tl-surface-2` | `#f5f5f4` (`stone-100`) | `#292524` (`stone-800`) | Subtle inset / table header |
| `--tl-border` | `#e7e5e4` (`stone-200`) | `#292524` (`stone-800`) | Hairline `1px` structural border |
| `--tl-border-strong` | `#d6d3d1` (`stone-300`) | `#44403c` (`stone-700`) | Input & interactive hover border |
| `--tl-text` | `#1c1917` (`stone-900`) | `#fafaf9` (`stone-50`) | `17.4:1` (Light) / `18.8:1` (Dark) |
| `--tl-text-secondary` | `#44403c` (`stone-700`) | `#d6d3d1` (`stone-300`) | `9.7:1` (Light) / `11.5:1` (Dark) |
| `--tl-text-muted` | `#57534e` (`stone-600`) | `#a8a29e` (`stone-400`) | `7.2:1` on white / `6.0:1` on `stone-800` |
| `--tl-accent-text` | `#b45309` (`amber-700`) | `#fbbf24` (`amber-400`) | `5.03:1` on white / `10.4:1` on `stone-900` |
| `--tl-accent-badge-fg` | `#92400e` (`amber-800`) | `#fcd34d` (`amber-300`) | `6.41:1` on `#fef3c7` (`amber-100`) |
| `--tl-accent-cta-bg` | `#f59e0b` (`amber-500`) | `#f59e0b` (`amber-500`) | With `#1c1917` ink = `8.15:1` (AAA) |

## Purpose-Gate Reason Log (R-31)
- **Single Sticky Backdrop Blur (`R-10`):** تنها روی نوار هدر چسبان بالا (`sticky top-0` با `backdrop-blur-md bg-stone-50/95 dark:bg-stone-950/95`) برای حفظ خوانایی هنگام عبور محتوا از زیر هدر استفاده می‌شود؛ تمامی کارت‌ها، دراپ‌داون‌ها و بردکرامب‌ها دارای سطح مات و مرز `1px` هستند.
- **Single Live Pulse Dot (`R-19`):** انیمیشن آرام نشانگر زنده صرفاً در نوار وضعیت نرخ زنده بازار (تیکر و پیش‌نمایش زنده تابلو) برای نمایش اتصال فعال وب‌سوکت/نرخ کاربرد دارد و با `prefers-reduced-motion` متوقف می‌شود.

## Owner-Verified Claims Log (R-36 / R-37)
موارد زیر در تاریخ `2026-11-01` توسط مالک کسب‌وکار تایید و مستند شده‌اند:
1. `+۳۵۰` گالری فعال در سراسر کشور (`resources/views/pages/about.blade.php`).
2. `ضمانت بازگشت وجه در صورت عدم رضایت` (`resources/views/pages/pricing.blade.php`).
3. `نرخ در دسترس‌پذیری ۹۹.۹٪` (`resources/views/pages/terms.blade.php`).
