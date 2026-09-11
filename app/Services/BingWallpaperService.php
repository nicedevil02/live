<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BingWallpaperService
{
    protected string $storageDir;
    protected string $imagePath;
    protected string $metaPath;

    public function __construct()
    {
        $basePublic = is_dir(base_path('public_html')) ? base_path('public_html') : public_path();
        $this->storageDir = $basePublic . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'bing';
        $this->imagePath  = $this->storageDir . DIRECTORY_SEPARATOR . 'today.jpg';
        $this->metaPath   = $this->storageDir . DIRECTORY_SEPARATOR . 'meta.json';
    }

    /**
     * دریافت تصویر روز با کش لوکال و بدون نشتی حافظه
     */
    public function getTodayWallpaper(): array
    {
        $today = now()->toDateString();

        // ۱. اگر متادیتا و تصویر امروز موجود است، مستقیماً از کش لوکال برگردانده شود (بدون درخواست شبکه)
        if (File::exists($this->imagePath) && File::exists($this->metaPath)) {
            try {
                $meta = json_decode(File::get($this->metaPath), true);
                if (is_array($meta) && isset($meta['date']) && $meta['date'] === $today && !empty($meta['url'])) {
                    return $meta;
                }
            } catch (\Throwable $e) {
                // در صورت خطا، دانلود مجدد انجام می‌شود
            }
        }

        // ۲. دانلود تصویر جدید روز با پاکسازی تضمینی تصاویر قبلی
        return $this->fetchAndStoreTodayWallpaper($today);
    }

    /**
     * دانلود تصویر و پاکسازی کامل تصاویر قبلی برای حفظ فضای هاست
     */
    protected function fetchAndStoreTodayWallpaper(string $today): array
    {
        if (!File::exists($this->storageDir)) {
            File::makeDirectory($this->storageDir, 0755, true);
        }

        $fallbackData = [
            'url'       => File::exists($this->imagePath) ? '/images/bing/today.jpg?d=' . $today : 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1920&auto=format&fit=crop',
            'title'     => 'منظره طبیعی روز',
            'copyright' => 'Bing Daily Wallpaper',
            'date'      => $today,
        ];

        try {
            $response = Http::timeout(6)->get('https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');

            if (!$response->successful()) {
                return $fallbackData;
            }

            $data = $response->json();
            $imageInfo = $data['images'][0] ?? null;

            if (!$imageInfo || empty($imageInfo['urlbase'])) {
                return $fallbackData;
            }

            $imageUrl = 'https://www.bing.com' . $imageInfo['urlbase'] . '_1920x1080.jpg';
            $title = $imageInfo['title'] ?? ($imageInfo['copyright'] ?? 'عکس روز بینگ');
            $copyright = $imageInfo['copyright'] ?? '';

            $imgResponse = Http::timeout(12)->get($imageUrl);

            if (!$imgResponse->successful() || strlen($imgResponse->body()) < 1000) {
                return $fallbackData;
            }

            // پاکسازی هر فایل قدیمی موجود در پوشه (تضمین عدم اشغال فضای هاست)
            $existingFiles = File::files($this->storageDir);
            foreach ($existingFiles as $file) {
                try {
                    File::delete($file->getPathname());
                } catch (\Throwable $t) {}
            }

            // ذخیره تصویر جدید روز با نام ثابت today.jpg
            File::put($this->imagePath, $imgResponse->body());

            // ذخیره متادیتای روز
            $meta = [
                'url'       => '/images/bing/today.jpg?d=' . $today,
                'title'     => $title,
                'copyright' => $copyright,
                'date'      => $today,
            ];
            File::put($this->metaPath, json_encode($meta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

            return $meta;
        } catch (\Throwable $e) {
            Log::warning('Bing daily wallpaper fetch warning: ' . $e->getMessage());
            return $fallbackData;
        }
    }
}
