<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisplaySetting;
use App\Models\DisplayItem;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DisplaySettingController extends Controller
{
    public const VALID_THEMES = [
        'dark-glass', 'light-modern', 'gold-royal', 'blue-ocean', 'purple-haze',
        'emerald-night', 'rose-dark', 'imperial-onyx', 'imperial-pearl',
        'pure-black', 'bing-daily', 'bing-studio', 'bing-ceramic',
    ];

    /**
     * نمایش صفحه تنظیمات تابلو
     */
    public function index()
    {
        self::ensureWeatherColumnsExist();
        self::ensureBoardEnhancementColumnsExist();
        $settings = DisplaySetting::firstOrCreate(['user_id' => auth()->id()], [
            'theme_mode' => 'light-modern',
            'slider_interval_sec' => 8,
            'show_weight' => true,
            'show_labor' => true,
            'show_profit' => true,
            'show_weather' => true,
            'show_weather_bg' => true,
            'hide_showcase' => false,
            'auto_theme_enabled' => false,
            'day_theme_mode' => 'light-modern',
            'night_theme_mode' => 'imperial-onyx',
            'day_start_time' => '07:00',
            'night_start_time' => '18:30',
            'footer_ticker_text' => '',
            'shop_name' => auth()->user()->name ?? 'گالری طلای جدید',
            'phone' => '',
            'instagram' => '',
            'rubika' => '',
            'qr_link' => '',
            'qr_label' => '',
            'qr_desc' => '',
            'published_at' => null,
        ]);

        $items = DisplayItem::where('user_id', auth()->id())->orderBy('order')->get();

        // پاسخ JSON برای درخواست‌های Alpine
        if (request()->expectsJson()) {
            return response()->json([
                'settings' => $settings,
                'items'    => $items,
            ]);
        }

        return view('admin.display-control.index', compact('settings', 'items'));
    }

    public function update(Request $request)
    {
        $this->ensureCityColumnsExist();
        self::ensureWeatherColumnsExist();
        self::ensureBoardEnhancementColumnsExist();
        $user = auth()->user();
        $settings = DisplaySetting::firstOrCreate(['user_id' => $user->id]);

        $validated = $request->validate([
            'theme_mode'          => ['required', 'string', Rule::in(self::VALID_THEMES)],
            'slider_interval_sec' => 'required|integer|min:3',
            'show_weight'         => 'sometimes|boolean',
            'show_labor'          => 'sometimes|boolean',
            'show_profit'         => 'sometimes|boolean',
            'show_weather'        => 'sometimes|boolean',
            'show_weather_bg'     => 'sometimes|boolean',
            'hide_showcase'       => 'sometimes|boolean',
            'auto_theme_enabled'  => 'sometimes|boolean',
            'day_theme_mode'      => ['nullable', 'string', Rule::in(self::VALID_THEMES)],
            'night_theme_mode'    => ['nullable', 'string', Rule::in(self::VALID_THEMES)],
            'day_start_time'      => ['nullable', 'string', 'regex:/^([01]\d|2[0-3]):[0-5]\d$/'],
            'night_start_time'    => ['nullable', 'string', 'regex:/^([01]\d|2[0-3]):[0-5]\d$/'],
            'footer_ticker_text'  => 'nullable|string|max:300',
            'shop_name'           => 'nullable|string|max:255',
            'city'                => 'nullable|string|max:50',
            'phone'               => 'nullable|string|max:20',
            'instagram'           => 'nullable|string|max:255',
            'rubika'              => 'nullable|string|max:255',
            'qr_link'             => 'nullable|string|max:1000',
            'qr_label'            => 'nullable|string|max:255',
            'qr_desc'             => 'nullable|string|max:255',
        ]);

        foreach (['show_weight', 'show_labor', 'show_profit', 'show_weather', 'show_weather_bg', 'hide_showcase', 'auto_theme_enabled'] as $boolField) {
            if ($request->has($boolField)) {
                $validated[$boolField] = $request->boolean($boolField);
            }
        }

        $validated['day_theme_mode'] = !empty($validated['day_theme_mode']) ? $validated['day_theme_mode'] : ($settings->day_theme_mode ?: 'light-modern');
        $validated['night_theme_mode'] = !empty($validated['night_theme_mode']) ? $validated['night_theme_mode'] : ($settings->night_theme_mode ?: 'imperial-onyx');
        $validated['day_start_time'] = !empty($validated['day_start_time']) ? $validated['day_start_time'] : ($settings->day_start_time ?: '07:00');
        $validated['night_start_time'] = !empty($validated['night_start_time']) ? $validated['night_start_time'] : ($settings->night_start_time ?: '18:30');
        if (array_key_exists('footer_ticker_text', $validated)) {
            $validated['footer_ticker_text'] = trim((string) ($validated['footer_ticker_text'] ?? ''));
        }

        if ($request->has('city')) {
            $cityInput = trim((string) $request->input('city', ''));
            $citiesConfig = config('cities', []);
            if (isset($citiesConfig[$cityInput])) {
                $user->city_slug = $cityInput;
                $user->city_name = $citiesConfig[$cityInput]['name'];
            } elseif ($cityInput === 'other' || $cityInput === 'iran') {
                $user->city_slug = 'iran';
                $user->city_name = 'ایران';
            }
        }

        if (!empty($validated['shop_name'])) {
            $user->name = $validated['shop_name'];
        }
        $user->save();

        // تبدیل مقادیر نال شده به رشته‌های خالی یا پیش‌فرض جهت هماهنگی با قیدهای پایگاه‌داده (NOT NULL)
        $validated['shop_name'] = $validated['shop_name'] ?? 'گالری طلای جدید';
        $validated['phone'] = $validated['phone'] ?? '';
        $validated['instagram'] = $validated['instagram'] ?? '';
        $validated['rubika'] = $validated['rubika'] ?? '';
        $validated['qr_link'] = $validated['qr_link'] ?? '';
        $validated['qr_label'] = $validated['qr_label'] ?? '';
        $validated['qr_desc'] = $validated['qr_desc'] ?? '';

        $settings->update($validated);

        return response()->json($settings);
    }

    /**
     * انتشار روی تابلو (ثبت زمان انتشار)
     */
    public function publish()
    {
        $settings = DisplaySetting::firstOrCreate(['user_id' => auth()->id()]);
        $settings->published_at = now();
        $settings->save();

        return response()->json([
            'message'      => 'انتشار با موفقیت انجام شد.',
            'published_at' => $settings->published_at->toISOString(),
        ]);
    }

    /**
     * دریافت مطمئن پیکربندی شهرها حتی در صورت کش بودن کانفیگ
     */
    public static function getCitiesConfig(): array
    {
        $cities = config('cities');
        if (empty($cities) || !is_array($cities)) {
            $cities = require config_path('cities.php');
        }
        return $cities ?: [];
    }

    /**
     * اطمینان از وجود ستون‌های شهر در دیتابیس بدون نیاز به دستور دستی
     */
    private function ensureCityColumnsExist(): void
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'city_slug')) {
                \Illuminate\Support\Facades\Schema::table('users', function ($table) {
                    $table->string('city_slug', 50)->nullable();
                    $table->string('city_name', 100)->nullable();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensureCityColumnsExist users error: ' . $e->getMessage());
        }

        try {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('display_settings', 'city_slug')) {
                \Illuminate\Support\Facades\Schema::table('display_settings', function ($table) {
                    $table->string('city_slug', 50)->nullable();
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensureCityColumnsExist display_settings error: ' . $e->getMessage());
        }
    }

    /**
     * نمایش صفحه اختصاصی اطلاعات فروشگاه و تنظیم کد QR
     */
    public function shopProfile()
    {
        $this->ensureCityColumnsExist();
        $user = auth()->user()->fresh();
        $settings = DisplaySetting::firstOrCreate(['user_id' => $user->id], [
            'theme_mode'          => 'light-modern',
            'slider_interval_sec' => 8,
            'show_weight'         => true,
            'show_labor'          => true,
            'show_profit'         => true,
            'shop_name'           => $user->name ?? 'گالری طلای جدید',
            'phone'               => $user->phone ?? '',
            'instagram'           => '',
            'rubika'              => '',
            'qr_link'             => '',
            'qr_label'            => '',
            'qr_desc'             => '',
            'published_at'        => null,
        ]);

        if (request()->expectsJson()) {
            return response()->json([
                'settings' => $settings,
                'user'     => $user,
            ]);
        }

        return view('admin.shop-profile.index', compact('settings', 'user'));
    }

    /**
     * به‌روزرسانی اطلاعات فروشگاه، شهر و تنظیم کد QR
     */
    public function updateShopProfile(Request $request)
    {
        $this->ensureCityColumnsExist();
        $user = auth()->user();
        $settings = DisplaySetting::firstOrCreate(['user_id' => $user->id]);

        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'city'      => 'nullable|string|max:50',
            'phone'     => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:255',
            'rubika'    => 'nullable|string|max:255',
            'qr_link'   => 'nullable|string|max:1000',
            'qr_label'  => 'nullable|string|max:255',
            'qr_desc'   => 'nullable|string|max:255',
        ]);

        $citiesConfig = self::getCitiesConfig();
        $cityInput = trim((string) $request->input('city', ''));

        if (empty($cityInput)) {
            $cityInput = $user->city_slug ?: 'tehran';
        }

        if (isset($citiesConfig[$cityInput])) {
            $citySlug = $cityInput;
            $cityName = $citiesConfig[$cityInput]['name'];
        } elseif ($cityInput === 'other' || $cityInput === 'iran') {
            $citySlug = 'iran';
            $cityName = 'ایران';
        } else {
            // جستجو بر اساس نام فارسی در صورت ارسال نام
            $found = null;
            foreach ($citiesConfig as $s => $c) {
                if (($c['name'] ?? '') === $cityInput) {
                    $found = [$s, $c['name']];
                    break;
                }
            }
            if ($found) {
                $citySlug = $found[0];
                $cityName = $found[1];
            } else {
                $citySlug = $cityInput;
                $cityName = $cityInput;
            }
        }

        // ۱. به‌روزرسانی مستقیم و تضمین‌شده در جدول users
        \Illuminate\Support\Facades\DB::table('users')->where('id', $user->id)->update([
            'city_slug'  => $citySlug,
            'city_name'  => $cityName,
            'name'       => $validated['shop_name'],
            'updated_at' => now(),
        ]);

        // ۲. به‌روزرسانی در جدول display_settings
        $displaySettingData = [
            'shop_name'    => $validated['shop_name'],
            'phone'        => $validated['phone'] ?? '',
            'instagram'    => $validated['instagram'] ?? '',
            'rubika'       => $validated['rubika'] ?? '',
            'qr_link'      => $validated['qr_link'] ?? '',
            'qr_label'     => $validated['qr_label'] ?? '',
            'qr_desc'      => $validated['qr_desc'] ?? '',
            'published_at' => now(),
            'updated_at'   => now(),
        ];

        if (\Illuminate\Support\Facades\Schema::hasColumn('display_settings', 'city_slug')) {
            $displaySettingData['city_slug'] = $citySlug;
        }

        \Illuminate\Support\Facades\DB::table('display_settings')->where('user_id', $user->id)->update($displaySettingData);

        $freshUser = \App\Models\User::find($user->id);
        $freshSettings = \App\Models\DisplaySetting::where('user_id', $user->id)->first();

        return response()->json([
            'message'   => 'اطلاعات فروشگاه و کد QR با موفقیت ذخیره شد.',
            'city_slug' => $citySlug,
            'city_name' => $cityName,
            'settings'  => $freshSettings,
            'user'      => $freshUser,
        ]);
    }

    /**
     * به‌روزرسانی سریع زمان‌بندی اسلایدر ویترین
     */
    public function updateSliderTiming(Request $request)
    {
        $validated = $request->validate([
            'slider_interval_sec' => 'required|integer|min:3|max:60',
        ]);

        $settings = DisplaySetting::firstOrCreate(['user_id' => auth()->id()]);
        $settings->slider_interval_sec = $validated['slider_interval_sec'];
        $settings->published_at = now();
        $settings->save();

        return response()->json([
            'message'             => 'زمان‌بندی اسلایدر با موفقیت به‌روزرسانی شد.',
            'slider_interval_sec' => $settings->slider_interval_sec,
        ]);
    }

    /**
     * اطمینان از وجود ستون‌های حالت ویترین خالی در جدول display_settings
     */
    public static function ensureEmptyShowcaseColumnsExist(): void
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('display_settings', 'empty_showcase_mode')) {
                \Illuminate\Support\Facades\Schema::table('display_settings', function ($table) {
                    $table->string('empty_showcase_mode', 30)->default('guide');
                    $table->string('empty_showcase_title', 150)->nullable();
                    $table->text('empty_showcase_text')->nullable();
                    $table->string('empty_showcase_theme', 30)->default('gold');
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensureEmptyShowcaseColumnsExist error: ' . $e->getMessage());
        }
    }

    /**
     * اطمینان از وجود ستون نمایش آب‌وهوا در جدول display_settings
     */
    public static function ensureWeatherColumnsExist(): void
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasColumn('display_settings', 'show_weather')) {
                \Illuminate\Support\Facades\Schema::table('display_settings', function ($table) {
                    $table->boolean('show_weather')->default(true);
                });
            }
            if (!\Illuminate\Support\Facades\Schema::hasColumn('display_settings', 'show_weather_bg')) {
                \Illuminate\Support\Facades\Schema::table('display_settings', function ($table) {
                    $table->boolean('show_weather_bg')->default(true);
                });
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensureWeatherColumnsExist error: ' . $e->getMessage());
        }
    }

    public static function ensureBoardEnhancementColumnsExist(): void
    {
        try {
            $existing = array_flip(\Illuminate\Support\Facades\Schema::getColumnListing('display_settings'));
            $specs = [
                'hide_showcase'      => ['boolean', [], false, false],
                'auto_theme_enabled' => ['boolean', [], false, false],
                'day_theme_mode'     => ['string', [40], 'light-modern', false],
                'night_theme_mode'   => ['string', [40], 'imperial-onyx', false],
                'day_start_time'     => ['string', [5], '07:00', false],
                'night_start_time'   => ['string', [5], '18:30', false],
                'footer_ticker_text' => ['string', [300], null, true],
            ];
            $missing = array_diff_key($specs, $existing);
            if (empty($missing)) {
                return;
            }

            \Illuminate\Support\Facades\Schema::table('display_settings', function ($table) use ($missing) {
                foreach ($missing as $name => [$type, $args, $default, $nullable]) {
                    $column = $table->{$type}($name, ...$args);
                    if ($nullable) {
                        $column->nullable();
                    }
                    if ($default !== null) {
                        $column->default($default);
                    }
                }
            });
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('ensureBoardEnhancementColumnsExist error: ' . $e->getMessage());
        }
    }

    /**
     * به‌روزرسانی تنظیمات ویترین در حالت بدون محصول (راهنما vs پیام اختصاصی)
     */
    public function updateEmptyShowcase(Request $request)
    {
        self::ensureEmptyShowcaseColumnsExist();
        $validated = $request->validate([
            'empty_showcase_mode'  => 'required|string|in:guide,custom_message',
            'empty_showcase_title' => 'nullable|string|max:150',
            'empty_showcase_text'  => 'nullable|string|max:500',
            'empty_showcase_theme' => 'nullable|string|in:gold,celebration,special_offer,royal',
        ]);

        $settings = DisplaySetting::firstOrCreate(['user_id' => auth()->id()]);
        $settings->empty_showcase_mode  = $validated['empty_showcase_mode'];
        $settings->empty_showcase_title = $validated['empty_showcase_title'] ?? '';
        $settings->empty_showcase_text  = $validated['empty_showcase_text'] ?? '';
        $settings->empty_showcase_theme = $validated['empty_showcase_theme'] ?? 'gold';
        $settings->published_at = now();
        $settings->save();

        return response()->json([
            'message'              => 'تنظیمات ویترین با موفقیت ذخیره شد و روی تابلو اعمال گردید.',
            'empty_showcase_mode'  => $settings->empty_showcase_mode,
            'empty_showcase_title' => $settings->empty_showcase_title,
            'empty_showcase_text'  => $settings->empty_showcase_text,
            'empty_showcase_theme' => $settings->empty_showcase_theme,
        ]);
    }

    /**
     * تغییر سریع وضعیت نمایش ویترین محصولات یا حالت تمام‌صفحه نرخ‌ها
     */
    public function updateShowcaseVisibility(Request $request)
    {
        self::ensureBoardEnhancementColumnsExist();
        $request->validate([
            'hide_showcase' => 'required|boolean',
        ]);

        $settings = DisplaySetting::firstOrCreate(['user_id' => auth()->id()]);
        $settings->hide_showcase = $request->boolean('hide_showcase');
        $settings->published_at = now();
        $settings->save();

        return response()->json([
            'message'       => $settings->hide_showcase
                ? 'حالت تمام‌صفحه نرخ‌ها فعال شد و ویترین در تابلو مخفی گردید.'
                : 'نمایش ویترین محصولات دوباره روی تابلو فعال شد.',
            'hide_showcase' => (bool) $settings->hide_showcase,
        ]);
    }
}
