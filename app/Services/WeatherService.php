<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    /**
     * جدول مختصات جغرافیایی مراکز استان‌ها و قطب‌های اصلی طلا و تجارت در ایران
     */
    protected static array $coordinates = [
        'tehran'        => ['lat' => 35.6892, 'lon' => 51.3890, 'name' => 'تهران'],
        'mashhad'       => ['lat' => 36.2972, 'lon' => 59.6067, 'name' => 'مشهد'],
        'isfahan'       => ['lat' => 32.6546, 'lon' => 51.6680, 'name' => 'اصفهان'],
        'tabriz'        => ['lat' => 38.0800, 'lon' => 46.2919, 'name' => 'تبریز'],
        'shiraz'        => ['lat' => 29.5918, 'lon' => 52.5837, 'name' => 'شیراز'],
        'ahvaz'         => ['lat' => 31.3183, 'lon' => 48.6706, 'name' => 'اهواز'],
        'qom'           => ['lat' => 34.6401, 'lon' => 50.8764, 'name' => 'قم'],
        'kermanshah'    => ['lat' => 34.3277, 'lon' => 47.0778, 'name' => 'کرمانشاه'],
        'urmia'         => ['lat' => 37.5527, 'lon' => 45.0761, 'name' => 'ارومیه'],
        'rasht'         => ['lat' => 37.2808, 'lon' => 49.5832, 'name' => 'رشت'],
        'zahedan'       => ['lat' => 29.4963, 'lon' => 60.8629, 'name' => 'زاهدان'],
        'hamedan'       => ['lat' => 34.7989, 'lon' => 48.5150, 'name' => 'همدان'],
        'kerman'        => ['lat' => 30.2839, 'lon' => 57.0834, 'name' => 'کرمان'],
        'yazd'          => ['lat' => 31.8974, 'lon' => 54.3569, 'name' => 'یزد'],
        'ardabil'       => ['lat' => 38.2498, 'lon' => 48.2933, 'name' => 'اردبیل'],
        'bandar-abbas'  => ['lat' => 27.1832, 'lon' => 56.2666, 'name' => 'بندرعباس'],
        'arak'          => ['lat' => 34.0954, 'lon' => 49.7013, 'name' => 'اراک'],
        'zanjan'        => ['lat' => 36.6736, 'lon' => 48.4787, 'name' => 'زنجان'],
        'sanandaj'      => ['lat' => 35.3219, 'lon' => 46.9862, 'name' => 'سنندج'],
        'qazvin'        => ['lat' => 36.2797, 'lon' => 50.0049, 'name' => 'قزوین'],
        'khorramabad'   => ['lat' => 33.4878, 'lon' => 48.3558, 'name' => 'خرم‌آباد'],
        'gorgan'        => ['lat' => 36.8427, 'lon' => 54.4439, 'name' => 'گرگان'],
        'sari'          => ['lat' => 36.5633, 'lon' => 53.0601, 'name' => 'ساری'],
        'bojnurd'       => ['lat' => 37.4747, 'lon' => 57.3290, 'name' => 'بجنورد'],
        'birjand'       => ['lat' => 32.8663, 'lon' => 59.2211, 'name' => 'بیرجند'],
        'bushehr'       => ['lat' => 28.9234, 'lon' => 50.8203, 'name' => 'بوشهر'],
        'ilam'          => ['lat' => 33.6374, 'lon' => 46.4227, 'name' => 'ایلام'],
        'semnan'        => ['lat' => 35.5729, 'lon' => 53.3971, 'name' => 'سمنان'],
        'yasuj'         => ['lat' => 30.6684, 'lon' => 51.5876, 'name' => 'یاسوج'],
        'shahrekord'    => ['lat' => 32.3256, 'lon' => 50.8644, 'name' => 'شهرکرد'],
        'karaj'         => ['lat' => 35.8400, 'lon' => 50.9391, 'name' => 'کرج'],
        'kashan'        => ['lat' => 33.9850, 'lon' => 51.4100, 'name' => 'کاشان'],
        'neyshabur'     => ['lat' => 36.2133, 'lon' => 58.7958, 'name' => 'نیشابور'],
        'dezful'        => ['lat' => 32.3811, 'lon' => 48.4058, 'name' => 'دزفول'],
        'abadan'        => ['lat' => 30.3392, 'lon' => 48.3043, 'name' => 'آبادان'],
        'kish'          => ['lat' => 26.5578, 'lon' => 53.9747, 'name' => 'کیش'],
        'qeshm'         => ['lat' => 26.9585, 'lon' => 56.2718, 'name' => 'قشم'],
        'chabahar'      => ['lat' => 25.2919, 'lon' => 60.6430, 'name' => 'چابهار'],
    ];

    /**
     * نگاشت استان به مرکز استان برای شهرستان‌ها
     */
    protected static array $provinceCapitals = [
        'تهران'              => 'tehran',
        'خراسان رضوی'        => 'mashhad',
        'اصفهان'             => 'isfahan',
        'آذربایجان شرقی'     => 'tabriz',
        'فارس'               => 'shiraz',
        'خوزستان'            => 'ahvaz',
        'قم'                 => 'qom',
        'کرمانشاه'           => 'kermanshah',
        'آذربایجان غربی'     => 'urmia',
        'گیلان'              => 'rasht',
        'سیستان و بلوچستان' => 'zahedan',
        'همدان'              => 'hamedan',
        'کرمان'              => 'kerman',
        'یزد'                => 'yazd',
        'اردبیل'             => 'ardabil',
        'هرمزگان'            => 'bandar-abbas',
        'مرکزی'              => 'arak',
        'زنجان'              => 'zanjan',
        'کردستان'            => 'sanandaj',
        'قزوین'              => 'qazvin',
        'لرستان'             => 'khorramabad',
        'گلستان'             => 'gorgan',
        'مازندران'           => 'sari',
        'خراسان شمالی'       => 'bojnurd',
        'خراسان جنوبی'       => 'birjand',
        'بوشهر'              => 'bushehr',
        'ایلام'              => 'ilam',
        'سمنان'              => 'semnan',
        'کهگیلویه و بویراحمد' => 'yasuj',
        'چهارمحال و بختیاری' => 'shahrekord',
        'البرز'              => 'karaj',
    ];

    /**
     * دریافت وضعیت آب‌وهوای شهر با کش هوشمند ۳۰ دقیقه‌ای
     */
    public function getWeatherForCity(?string $citySlug = 'tehran', ?string $cityName = 'تهران'): array
    {
        $citySlug = $citySlug ?: 'tehran';
        $cityName = $cityName ?: 'تهران';
        $cacheKey = 'display_weather_v1_' . $citySlug;

        return Cache::remember($cacheKey, 1800, function () use ($citySlug, $cityName) {
            return $this->fetchFromOpenMeteo($citySlug, $cityName);
        });
    }

    /**
     * فراخوانی وب‌سرویس Open-Meteo
     */
    protected function fetchAndParse(float $lat, float $lon, string $cityName, string $citySlug): ?array
    {
        try {
            $url = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current=temperature_2m,relative_humidity_2m,weather_code,is_day&timezone=auto";
            $response = Http::timeout(3)->get($url);

            if ($response->successful()) {
                $data = $response->json();
                $current = $data['current'] ?? null;
                if ($current && isset($current['temperature_2m'])) {
                    $tempRaw = (float) $current['temperature_2m'];
                    $tempRounded = (int) round($tempRaw);
                    $code = (int) ($current['weather_code'] ?? 0);
                    $isDay = (bool) ($current['is_day'] ?? 1);
                    $humidity = (int) ($current['relative_humidity_2m'] ?? 0);

                    $meta = $this->interpretWeatherCode($code, $isDay);

                    return [
                        'city'        => $cityName,
                        'city_slug'   => $citySlug,
                        'temp'        => $tempRounded,
                        'temp_farsi'  => $this->toFarsiDigits($tempRounded),
                        'description' => $meta['description'],
                        'icon'        => $meta['icon'],
                        'iconBg'      => $meta['iconBg'],
                        'humidity'    => $humidity,
                        'is_day'      => $isDay,
                        'updated_at'  => now()->toISOString(),
                    ];
                }
            }
        } catch (\Throwable $e) {
            Log::warning("Open-Meteo fetch failed for {$citySlug}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * دریافت یا تولید فال‌بک مطمئن
     */
    protected function fetchFromOpenMeteo(string $citySlug, string $cityName): array
    {
        $coords = $this->resolveCoordinates($citySlug);
        $result = $this->fetchAndParse($coords['lat'], $coords['lon'], $cityName, $citySlug);

        if ($result) {
            return $result;
        }

        // فال‌بک ایمن در صورت کندی یا قطعی موقت اینترنت
        return [
            'city'        => $cityName,
            'city_slug'   => $citySlug,
            'temp'        => 22,
            'temp_farsi'  => '۲۲',
            'description' => 'صاف و آفتابی',
            'icon'        => 'sun',
            'iconBg'      => 'bg-amber-500/20 text-amber-400',
            'humidity'    => 35,
            'is_day'      => true,
            'updated_at'  => now()->toISOString(),
            'is_fallback' => true,
        ];
    }

    /**
     * تشخیص مختصات جغرافیایی بر اساس اسلاگ شهر یا استان مربوطه
     */
    protected function resolveCoordinates(string $citySlug): array
    {
        if (isset(self::$coordinates[$citySlug])) {
            return self::$coordinates[$citySlug];
        }

        // بررسی از فایل کانفیگ شهرها جهت استخراج استان
        $citiesConfig = config('cities', []);
        if (isset($citiesConfig[$citySlug])) {
            $province = $citiesConfig[$citySlug]['province'] ?? null;
            if ($province && isset(self::$provinceCapitals[$province])) {
                $capitalSlug = self::$provinceCapitals[$province];
                if (isset(self::$coordinates[$capitalSlug])) {
                    return self::$coordinates[$capitalSlug];
                }
            }
        }

        // پیش‌فرض: تهران
        return self::$coordinates['tehran'];
    }

    /**
     * ترجمه کدهای استاندارد هواشناسی WMO به فارسی و آیکون مناسب
     */
    protected function interpretWeatherCode(int $code, bool $isDay): array
    {
        if ($code === 0) {
            if ($isDay) {
                return ['description' => 'صاف و آفتابی', 'icon' => 'sun', 'iconBg' => 'bg-amber-500/20 text-amber-400'];
            }
            return ['description' => 'آسمان صاف و آرام', 'icon' => 'moon', 'iconBg' => 'bg-indigo-500/20 text-indigo-300'];
        }

        switch ($code) {
            case 1:
                return ['description' => 'عمدتاً صاف', 'icon' => $isDay ? 'sun' : 'moon', 'iconBg' => $isDay ? 'bg-amber-500/20 text-amber-400' : 'bg-indigo-500/20 text-indigo-300'];
            case 2:
                return ['description' => 'کمی ابری', 'icon' => 'cloud-sun', 'iconBg' => 'bg-sky-500/20 text-sky-400'];
            case 3:
                return ['description' => 'نیمه‌ابری تا تمام‌ابری', 'icon' => 'cloud', 'iconBg' => 'bg-stone-500/20 text-stone-300'];
            case 45:
            case 48:
                return ['description' => 'مه‌آلود', 'icon' => 'cloud', 'iconBg' => 'bg-stone-500/20 text-stone-300'];
            case 51:
            case 53:
            case 55:
                return ['description' => 'باران پراکنده و نم‌نم', 'icon' => 'rain', 'iconBg' => 'bg-blue-500/20 text-blue-400'];
            case 61:
                return ['description' => 'باران ملایم', 'icon' => 'rain', 'iconBg' => 'bg-blue-500/20 text-blue-400'];
            case 63:
                return ['description' => 'بارانی', 'icon' => 'rain', 'iconBg' => 'bg-blue-500/25 text-blue-400'];
            case 65:
                return ['description' => 'باران شدید', 'icon' => 'rain', 'iconBg' => 'bg-blue-500/30 text-blue-400'];
            case 71:
            case 73:
            case 75:
            case 77:
                return ['description' => 'بارش برف', 'icon' => 'snow', 'iconBg' => 'bg-cyan-500/25 text-cyan-300'];
            case 80:
            case 81:
            case 82:
                return ['description' => 'رگبار باران', 'icon' => 'rain', 'iconBg' => 'bg-blue-600/30 text-blue-300'];
            case 85:
            case 86:
                return ['description' => 'رگبار برف', 'icon' => 'snow', 'iconBg' => 'bg-cyan-500/30 text-cyan-200'];
            case 95:
            case 96:
            case 99:
                return ['description' => 'رعد و برق و باران', 'icon' => 'thunder', 'iconBg' => 'bg-yellow-500/25 text-yellow-400'];
            default:
                return ['description' => 'هوای معتدل', 'icon' => $isDay ? 'sun' : 'moon', 'iconBg' => 'bg-amber-500/20 text-amber-400'];
        }
    }

    /**
     * تبدیل ارقام انگلیسی به فارسی
     */
    public static function toFarsiDigits($number): string
    {
        $farsi = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($english, $farsi, (string) $number);
    }
}
