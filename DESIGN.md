# TalaLive Public Design System (DESIGN.md)

## Direction (Apple HIG Spatial Glass + Luxury Obsidian Noir & Pure White Canvas)
1. **Domain & Audience:** سامانه ابری تابلوی نرخ لحظه‌ای طلا، سکه و ارز ویژه صاحبان گالری‌های طلا و جواهر و صرافی‌های ایران.
2. **Aesthetic Character:** تلفیق بوم سفید خالص و درخشان (**Pure Crisp White Canvas `#FFFFFF`**) با متریال شیشه‌ای زنده اپل (**Apple HIG Liquid Frosted Glass**) در لایه‌های شناور و دکمه‌های پرمیوم اسلیت شبانه (**Luxury Midnight Obsidian Slate `#0F172A`**) با متن سفید و هایلایت لبه ظریف؛ حذف رنگ طلایی جیغ و بازاری از دکمه‌ها و جایگزینی با وقار و کنتراست بالای ۱۷ به ۱ به سبک اپل و استرایپ.
3. **Color & Lighting Physics:**
   - بوم سفید تمیز (`#FFFFFF`) در تم روز و گرافیت ابسیدین (`#141312`) در تم شب.
   - کارت‌های سفید شناور با سایه ترازهای اپل (`box-shadow: 0 1px 3px rgba(15,23,42,0.03), 0 8px 24px -4px rgba(15,23,42,0.06)` و مرز ظریف `rgba(15,23,42,0.08)`).
   - دکمه‌های اصلی پرمیوم اسلیت عمیق (`#0F172A` تا `#1E293B`) با متن سفید خالص `#FFFFFF` در تم روشن؛ و دکمه‌های مرواریدی درخشان `#FFFFFF` با متن تیره در تم تاریک.
   - حفظ رنگ طلای غنی (`#B45309` در روز، `#FBBF24` در شب) منحصراً برای اعداد نرخ زنده، حباب سکه و بج‌های تخصصی بدون سنگین کردن یا زرد کردن کل صفحه.
4. **Typography & Iconography:** فونت یکپارچه `Vazirmatn` با کف سایز استاندارد، اعداد هم‌عرض (`tabular-nums`) برای نمایشگرهای نرخ و ماشین‌حساب‌ها، و آیکون‌های برداری هندسی `1.5px` بدون ایموجی.
5. **Spatial & Motion Dials:** `Dial: ENERGY 2 (Balanced Luxury) / RHYTHM 2 (Measured Studio Variation) / MOTION 2 (Apple Spring Physics cubic-bezier(0.22, 1, 0.36, 1), 60fps GPU-safe, reduced-motion compliant)`.

## Semantic Color & Lighting Tokens (WCAG AA Mathematically Verified >= 4.5:1)

| Token | Light Mode (`Pure Crisp White`) | Dark Mode (`Midnight Obsidian Graphite`) | Contrast / Physics Role |
| :--- | :--- | :--- | :--- |
| `--tl-bg` | `#FFFFFF` | `#141312` | Pure, crisp base canvas |
| `--tl-surface` | `#FFFFFF` | `#1D1B19` | Elevated card surface with Apple elevation |
| `--tl-inset-bg` | `#F8FAFC` | `#0D0C0B` | Clean recessed well for inputs & tracks |
| `--tl-glass-bg` | `rgba(255, 255, 255, 0.88)` | `rgba(24, 22, 20, 0.76)` | `blur(24px) saturate(190%)` Apple Crystal Vibrancy |
| `--tl-text` | `#0F172A` (`slate-900`) | `#FAFAF9` (`stone-50`) | `17.85:1` (Light) / `17.6:1` (Dark) - AAA |
| `--tl-text-secondary` | `#334155` (`slate-700`) | `#D6D3D1` (`stone-300`) | `10.35:1` (Light) / `11.1:1` (Dark) - AAA |
| `--tl-text-muted` | `#64748B` (`slate-500`) | `#A8A29E` (`stone-400`) | `4.76:1` on `#FFFFFF` / `6.81:1` on dark card - AA |
| `--tl-accent-text` | `#B45309` (`amber-700`) | `#FBBF24` (`amber-400`) | `5.02:1` on `#FFFFFF` / `10.29:1` on `#1D1B19` - AA |
| `--tl-primary-cta` | `#0F172A -> #1E293B` (White text) | `#FFFFFF -> #F1F5F9` (Dark text) | `17.85:1` AAA Contrast (Midnight Obsidian) |

## Owner-Directed Overrides & Purpose-Gate Reason Log (R-31 / R-37)
طبق دستور مستقیم مالک محصول در تاریخ `2026-11-01`:
1. **Pure White Canvas (`#FFFFFF`):** حذف ته‌رنگ کرم و بژ و جایگزینی با بوم سفید شفاف و درخشان جهت افزایش تمیزی، شفافیت و روح بصری سایت.
2. **Luxury Obsidian Noir Buttons:** دکمه‌های زرد و طلایی پررنگ بازاری که چشم را خسته می‌کرد حذف شدند و با دکمه‌های پرمیوم و باوقار اسلیت نیمه‌شب (`#0F172A`) با فونت سفید شارپ و مرز نوری بازتابی ۱ پیکسلی جایگزین شدند.
3. **Apple HIG Liquid Frosted Glass:** استفاده هدفمند از شیشه مات کریستالی در لایه‌های شناور کپسول هدر، منوهای دراپ‌داون و کشوی موبایل حفظ شد.
4. **Warm 18K Gold Studio Bias Lighting:** هاله نوری پشت ماکت تلویزیون به شکل ملایم و نرم (`filter: blur(48px)`) تنظیم شد تا بدون زرد کردن صفحه سفید، عمق استودیویی لوکس را ایجاد کند.

## Owner-Verified Claims Log (R-36 / R-37)
موارد زیر در تاریخ `2026-11-01` توسط مالک کسب‌وکار تایید و مستند شده‌اند:
1. `+۳۵۰` گالری فعال در سراسر کشور (`resources/views/pages/about.blade.php` و `resources/views/pages/smart-gold-board.blade.php`).
2. `ضمانت بازگشت وجه در صورت عدم رضایت` (`resources/views/pages/pricing.blade.php`).
3. `نرخ در دسترس‌پذیری ۹۹.۹٪` (`resources/views/pages/terms.blade.php`).
