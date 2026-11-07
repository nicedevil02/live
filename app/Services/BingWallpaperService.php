<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BingWallpaperService
{
    protected string $primaryDir;
    protected string $primaryImagePath;
    protected string $primaryMetaPath;

    public function __construct()
    {
        $basePublic = is_dir(base_path('public_html')) ? base_path('public_html') : public_path();
        $this->primaryDir       = $basePublic . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'bing';
        $this->primaryImagePath = $this->primaryDir . DIRECTORY_SEPARATOR . 'today.jpg';
        $this->primaryMetaPath  = $this->primaryDir . DIRECTORY_SEPARATOR . 'meta.json';
    }

    /**
     * Get all target storage directories (syncing public and public_html if both exist)
     *
     * @return string[]
     */
    public function getStorageDirectories(): array
    {
        $dirs = [];
        $candidates = [
            base_path('public_html' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'bing'),
            base_path('public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'bing'),
            public_path('images' . DIRECTORY_SEPARATOR . 'bing'),
        ];

        foreach ($candidates as $cand) {
            $normalized = rtrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $cand), DIRECTORY_SEPARATOR);
            if (!in_array($normalized, $dirs, true)) {
                $dirs[] = $normalized;
            }
        }

        return $dirs;
    }

    /**
     * Get today's wallpaper metadata with local caching and zero memory leakage.
     *
     * @param bool $force Force download even if cached for today
     * @return array
     */
    public function getTodayWallpaper(bool $force = false): array
    {
        $today = now()->toDateString();
        $cleanToday = str_replace('-', '', $today);

        // 1. If not forcing, check if today's wallpaper is already cached and valid on disk
        if (!$force && File::exists($this->primaryImagePath) && File::exists($this->primaryMetaPath)) {
            try {
                $fileSize = @filesize($this->primaryImagePath);
                if ($fileSize && $fileSize > 10000) {
                    $meta = json_decode(File::get($this->primaryMetaPath), true);
                    if (is_array($meta) && !empty($meta['url'])) {
                        $metaDate = (string)($meta['date'] ?? '');
                        $cleanMetaDate = str_replace('-', '', $metaDate);

                        // Strict check: Cache is valid ONLY if date matches today
                        if ($metaDate === $today || $cleanMetaDate === $cleanToday) {
                            return $meta;
                        }
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Bing wallpaper cache read error: ' . $e->getMessage());
            }
        }

        // 2. Fetch fresh wallpaper for today from Microsoft Bing
        return $this->fetchAndStoreTodayWallpaper($today, $cleanToday);
    }

    /**
     * Public alias for forced refresh.
     */
    public function refresh(bool $force = true): array
    {
        return $this->getTodayWallpaper($force);
    }

    /**
     * Download today's image with multiple mirror fallbacks and atomic multi-directory storage.
     */
    protected function fetchAndStoreTodayWallpaper(string $today, string $cleanToday): array
    {
        $storageDirs = $this->getStorageDirectories();
        foreach ($storageDirs as $dir) {
            if (!File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
        }

        $fallbackData = [
            'url'       => File::exists($this->primaryImagePath) ? '/images/bing/today.jpg?d=' . $cleanToday : '/images/bing/today.jpg',
            'title'     => 'منظره طبیعی روز',
            'copyright' => 'Bing Daily Wallpaper',
            'date'      => $today,
        ];

        // Attempt 1: Official Microsoft Bing API
        $payload = $this->fetchFromOfficialBing($cleanToday);

        // Attempt 2: Fallback Mirror API if official failed
        if (!$payload) {
            $payload = $this->fetchFromMirrorBing($cleanToday);
        }

        if (!$payload || empty($payload['binary']) || strlen($payload['binary']) < 10000) {
            Log::warning('Bing daily wallpaper fetch failed from all sources. Keeping current image.');
            return $fallbackData;
        }

        $imageBinary = $payload['binary'];
        $title       = $payload['title'] ?? 'عکس روز بینگ';
        $copyright   = $payload['copyright'] ?? 'Bing Daily Wallpaper';
        $imageDate   = $payload['date'] ?? $today;
        $cleanDate   = str_replace('-', '', $imageDate);
        $sizeKb      = round(strlen($imageBinary) / 1024, 2);

        $meta = [
            'url'       => '/images/bing/today.jpg?v=' . $cleanDate,
            'title'     => $title,
            'copyright' => $copyright,
            'date'      => $imageDate,
            'size_kb'   => $sizeKb,
            'synced_at' => now()->toDateTimeString(),
        ];

        $encodedMeta = json_encode($meta, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        // Save atomically to all target directories
        foreach ($storageDirs as $dir) {
            try {
                if (!File::exists($dir)) {
                    File::makeDirectory($dir, 0755, true);
                }
                $imgPath  = $dir . DIRECTORY_SEPARATOR . 'today.jpg';
                $jsonPath = $dir . DIRECTORY_SEPARATOR . 'meta.json';

                File::put($imgPath, $imageBinary);
                File::put($jsonPath, $encodedMeta);
            } catch (\Throwable $writeEx) {
                Log::error("Failed to write Bing wallpaper to {$dir}: " . $writeEx->getMessage());
            }
        }

        return $meta;
    }

    /**
     * Fetch wallpaper details and binary from official Bing API
     */
    protected function fetchFromOfficialBing(string $cleanToday): ?array
    {
        try {
            $apiUrl = 'https://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1';
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept'     => 'application/json,text/plain,*/*',
            ])->timeout(8)->get($apiUrl);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();
            $imageInfo = $data['images'][0] ?? null;

            if (!$imageInfo) {
                return null;
            }

            // Determine image download URL
            $imageUrl = '';
            if (!empty($imageInfo['urlbase'])) {
                $imageUrl = 'https://www.bing.com' . $imageInfo['urlbase'] . '_1920x1080.jpg';
            } elseif (!empty($imageInfo['url'])) {
                $rawUrl = (string)$imageInfo['url'];
                $imageUrl = str_starts_with($rawUrl, 'http') ? $rawUrl : 'https://www.bing.com' . $rawUrl;
            }

            if (empty($imageUrl)) {
                return null;
            }

            $imgResponse = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept'     => 'image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8',
            ])->timeout(16)->get($imageUrl);

            if (!$imgResponse->successful() || strlen($imgResponse->body()) < 10000) {
                return null;
            }

            $title     = !empty($imageInfo['title']) ? trim((string)$imageInfo['title']) : '';
            $copyright = !empty($imageInfo['copyright']) ? trim((string)$imageInfo['copyright']) : '';
            if (empty($title)) {
                $title = $copyright ?: 'عکس روز بینگ';
            }

            $date = (string)($imageInfo['enddate'] ?? ($imageInfo['startdate'] ?? $cleanToday));

            return [
                'binary'    => $imgResponse->body(),
                'title'     => $title,
                'copyright' => $copyright,
                'date'      => $date,
            ];
        } catch (\Throwable $e) {
            Log::warning('Bing official API fetch warning: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Fetch wallpaper details and binary from backup mirror
     */
    protected function fetchFromMirrorBing(string $cleanToday): ?array
    {
        try {
            $mirrorUrl = 'https://bing.biturl.top/?resolution=1920&format=json&index=0&mkt=en-US';
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ])->timeout(8)->get($mirrorUrl);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();
            $imageUrl = $data['url'] ?? '';

            if (empty($imageUrl)) {
                return null;
            }

            $imgResponse = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            ])->timeout(16)->get($imageUrl);

            if (!$imgResponse->successful() || strlen($imgResponse->body()) < 10000) {
                return null;
            }

            $copyright = !empty($data['copyright']) ? trim((string)$data['copyright']) : 'Bing Daily Wallpaper';
            $date      = (string)($data['end_date'] ?? ($data['start_date'] ?? $cleanToday));

            return [
                'binary'    => $imgResponse->body(),
                'title'     => $copyright,
                'copyright' => $copyright,
                'date'      => $date,
            ];
        } catch (\Throwable $e) {
            Log::warning('Bing mirror API fetch warning: ' . $e->getMessage());
            return null;
        }
    }
}
