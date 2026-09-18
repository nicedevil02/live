<?php

namespace App\Services;

class QrService
{
    /**
     * تولید تصویر PNG برای کد QR با ابعاد مشخص به صورت ۱۰۰٪ خالص و بدون وابستگی
     */
    public static function generatePng(string $text, int $size = 250): string
    {
        $matrix = self::generateMatrix($text);
        $modules = count($matrix);
        $quietZone = 4;
        $totalModules = $modules + ($quietZone * 2);

        $moduleSize = max(1, (int) floor($size / $totalModules));
        $imgSize = $totalModules * $moduleSize;

        if (function_exists('imagecreatetruecolor')) {
            $img = imagecreatetruecolor($imgSize, $imgSize);
            $white = imagecolorallocate($img, 255, 255, 255);
            $black = imagecolorallocate($img, 15, 23, 42); // تم تیره طلالایو

            imagefilledrectangle($img, 0, 0, $imgSize - 1, $imgSize - 1, $white);

            for ($r = 0; $r < $modules; $r++) {
                for ($c = 0; $c < $modules; $c++) {
                    if ($matrix[$r][$c]) {
                        $x = ($c + $quietZone) * $moduleSize;
                        $y = ($r + $quietZone) * $moduleSize;
                        imagefilledrectangle($img, $x, $y, $x + $moduleSize - 1, $y + $moduleSize - 1, $black);
                    }
                }
            }

            ob_start();
            imagepng($img);
            $data = ob_get_clean();
            imagedestroy($img);
            return $data;
        }

        // اگر GD در دسترس نبود، تولید مستقیم تصویر با فرمت خام PNG بدون نیاز به کتابخانه
        return self::buildRawPng($matrix, $quietZone, $moduleSize);
    }

    /**
     * پیاده‌سازی استاندارد و بهینه تولید ماتریس QR Code (نسخه ۱ تا ۴ بر اساس طول رشته)
     */
    public static function generateMatrix(string $text): array
    {
        $bytes = array_values(unpack('C*', $text));
        $len = count($bytes);

        // تعیین نسخه مناسب (Version 1..4)
        if ($len <= 14) {
            $version = 1; $totalCodewords = 26; $dataCodewords = 16;
        } elseif ($len <= 26) {
            $version = 2; $totalCodewords = 44; $dataCodewords = 28;
        } elseif ($len <= 42) {
            $version = 3; $totalCodewords = 70; $dataCodewords = 44;
        } else {
            $version = 4; $totalCodewords = 100; $dataCodewords = 64;
        }

        $modules = 17 + 4 * $version;
        $matrix = array_fill(0, $modules, array_fill(0, $modules, null));

        // ۱. رسم الگوهای موقعیت‌یاب (Finder Patterns 7x7)
        self::placeFinder($matrix, 0, 0);
        self::placeFinder($matrix, $modules - 7, 0);
        self::placeFinder($matrix, 0, $modules - 7);

        // ۲. رسم خطوط تنظیم زمان (Timing Patterns)
        for ($i = 8; $i < $modules - 8; $i++) {
            $val = ($i % 2 === 0);
            if ($matrix[6][$i] === null) $matrix[6][$i] = $val;
            if ($matrix[$i][6] === null) $matrix[$i][6] = $val;
        }

        // ۳. الگوی تراز (Alignment Pattern برای نسخه‌های ۲ به بالا)
        if ($version >= 2) {
            $alignPos = [18, 22, 26][$version - 2];
            self::placeAlignment($matrix, $alignPos, $alignPos);
        }

        // ۴. متغیرهای رزرو شده برای Format Info
        for ($i = 0; $i < 9; $i++) {
            if ($matrix[8][$i] === null) $matrix[8][$i] = false;
            if ($matrix[$i][8] === null) $matrix[$i][8] = false;
        }
        for ($i = $modules - 8; $i < $modules; $i++) {
            if ($matrix[8][$i] === null) $matrix[8][$i] = false;
            if ($matrix[$i][8] === null) $matrix[$i][8] = false;
        }
        $matrix[$modules - 8][8] = true; // Dark module

        // ۵. کدگذاری داده‌ها (Byte Mode = 0100)
        $bits = [0, 1, 0, 0];
        for ($b = 7; $b >= 0; $b--) {
            $bits[] = ($len >> $b) & 1;
        }
        foreach ($bytes as $byte) {
            for ($b = 7; $b >= 0; $b--) {
                $bits[] = ($byte >> $b) & 1;
            }
        }

        // افزودن Terminator و Padding تا اندازه مجاز داده
        $maxBits = $dataCodewords * 8;
        for ($i = 0; $i < 4 && count($bits) < $maxBits; $i++) {
            $bits[] = 0;
        }
        while (count($bits) % 8 !== 0) {
            $bits[] = 0;
        }
        $padBytes = [0xEC, 0x11];
        $padIdx = 0;
        while (count($bits) < $maxBits) {
            $pad = $padBytes[$padIdx % 2];
            for ($b = 7; $b >= 0; $b--) {
                $bits[] = ($pad >> $b) & 1;
            }
            $padIdx++;
        }

        // تبدیل بیت‌ها به بایت
        $dataBytes = [];
        for ($i = 0; $i < count($bits); $i += 8) {
            $v = 0;
            for ($j = 0; $j < 8; $j++) {
                $v = ($v << 1) | $bits[$i + $j];
            }
            $dataBytes[] = $v;
        }

        // محاسبه کدهای تصحیح خطا با Reed-Solomon
        $ecCount = $totalCodewords - $dataCodewords;
        $ecBytes = self::calculateReedSolomon($dataBytes, $ecCount);
        $allCodewords = array_merge($dataBytes, $ecBytes);

        // تبدیل کلمات به رشته بیت برای قرارگیری در ماتریکس
        $streamBits = [];
        foreach ($allCodewords as $cw) {
            for ($b = 7; $b >= 0; $b--) {
                $streamBits[] = ($cw >> $b) & 1;
            }
        }

        // ۶. جای‌گذاری داده‌ها در ماتریس به صورت زیگزاگی
        $bitIdx = 0;
        $numBits = count($streamBits);
        $up = true;
        for ($right = $modules - 1; $right > 0; $right -= 2) {
            if ($right === 6) $right--; // عبور از خط عمودی تایمینگ
            $rows = $up ? range($modules - 1, 0) : range(0, $modules - 1);
            foreach ($rows as $r) {
                foreach ([$right, $right - 1] as $c) {
                    if ($matrix[$r][$c] === null) {
                        $bit = ($bitIdx < $numBits) ? $streamBits[$bitIdx++] : 0;
                        // اعمال ماسک صفر استاندارد: (row + col) % 2 == 0
                        $mask = (($r + $c) % 2 === 0);
                        $matrix[$r][$c] = ($bit === 1) ^ $mask;
                    }
                }
            }
            $up = !$up;
        }

        // ۷. ثبت اطلاعات قالب (Format Information برای ECC=M و Mask=0: بیت‌های 0b101010000010010)
        $formatBits = [1,0,1,0,1,0,0,0,0,0,1,0,0,1,0];
        $fIdx = 0;
        for ($c = 0; $c <= 5; $c++) $matrix[8][$c] = (bool)$formatBits[$fIdx++];
        $matrix[8][7] = (bool)$formatBits[$fIdx++];
        $matrix[8][8] = (bool)$formatBits[$fIdx++];
        $matrix[7][8] = (bool)$formatBits[$fIdx++];
        for ($r = 5; $r >= 0; $r--) $matrix[$r][8] = (bool)$formatBits[$fIdx++];

        $fIdx = 0;
        for ($r = $modules - 1; $r >= $modules - 7; $r--) $matrix[$r][8] = (bool)$formatBits[$fIdx++];
        for ($c = $modules - 8; $c < $modules; $c++) $matrix[8][$c] = (bool)$formatBits[$fIdx++];

        return $matrix;
    }

    private static function placeFinder(&$matrix, $x, $y): void
    {
        for ($r = -1; $r <= 7; $r++) {
            for ($c = -1; $c <= 7; $c++) {
                $mr = $y + $r;
                $mc = $x + $c;
                if ($mr >= 0 && $mr < count($matrix) && $mc >= 0 && $mc < count($matrix)) {
                    if ($r >= 0 && $r <= 6 && $c >= 0 && $c <= 6) {
                        $matrix[$mr][$mc] = ($r === 0 || $r === 6 || $c === 0 || $c === 6 || ($r >= 2 && $r <= 4 && $c >= 2 && $c <= 4));
                    } else {
                        $matrix[$mr][$mc] = false;
                    }
                }
            }
        }
    }

    private static function placeAlignment(&$matrix, $cx, $cy): void
    {
        for ($r = -2; $r <= 2; $r++) {
            for ($c = -2; $c <= 2; $c++) {
                $matrix[$cy + $r][$cx + $c] = (max(abs($r), abs($c)) !== 1);
            }
        }
    }

    private static function calculateReedSolomon(array $data, int $ecCount): array
    {
        // جدول گالوآ GF(256) با چندجمله‌ای 0x11D
        $exp = array_fill(0, 512, 0);
        $log = array_fill(0, 256, 0);
        $x = 1;
        for ($i = 0; $i < 255; $i++) {
            $exp[$i] = $x;
            $exp[$i + 255] = $x;
            $log[$x] = $i;
            $x <<= 1;
            if ($x & 0x100) $x ^= 0x11D;
        }

        // تولید چندجمله‌ای مولد (Generator Polynomial)
        $gen = [1];
        for ($i = 0; $i < $ecCount; $i++) {
            $next = array_fill(0, count($gen) + 1, 0);
            $factor = $exp[$i];
            for ($j = 0; $j < count($gen); $j++) {
                $next[$j] ^= $gen[$j];
                $prod = ($gen[$j] === 0 || $factor === 0) ? 0 : $exp[$log[$gen[$j]] + $log[$factor]];
                $next[$j + 1] ^= $prod;
            }
            $gen = $next;
        }

        // تقسیم داده‌ها بر چندجمله‌ای مولد
        $res = array_fill(0, $ecCount, 0);
        foreach ($data as $byte) {
            $factor = $byte ^ $res[0];
            array_shift($res);
            $res[] = 0;
            if ($factor !== 0) {
                $logFactor = $log[$factor];
                for ($j = 0; $j < $ecCount; $j++) {
                    if ($gen[$j + 1] !== 0) {
                        $res[$j] ^= $exp[$logFactor + $log[$gen[$j + 1]]];
                    }
                }
            }
        }
        return $res;
    }

    private static function buildRawPng(array $matrix, int $quiet, int $modSize): string
    {
        // ساخت مستقیم باینری PNG به عنوان Fallback مطمئن در شرایط نبود GD
        $mods = count($matrix);
        $total = $mods + ($quiet * 2);
        $width = $total * $modSize;
        $height = $width;

        // تولید بایت‌های خام تصویر تک‌رنگ و بسته‌بندی با Deflate
        $rawScanlines = '';
        for ($y = 0; $y < $height; $y++) {
            $rawScanlines .= "\x00"; // فیلتر خط: None
            $my = (int) floor($y / $modSize) - $quiet;
            for ($x = 0; $x < $width; $x++) {
                $mx = (int) floor($x / $modSize) - $quiet;
                $isDark = ($my >= 0 && $my < $mods && $mx >= 0 && $mx < $mods && $matrix[$my][$mx]);
                $rawScanlines .= $isDark ? "\x0F\x17\x2A" : "\xFF\xFF\xFF";
            }
        }

        $idat = gzcompress($rawScanlines, 9);
        $ihdr = pack('NNCCCCC', $width, $height, 8, 2, 0, 0, 0);

        return "\x89PNG\r\n\x1a\n" .
            self::pngChunk('IHDR', $ihdr) .
            self::pngChunk('IDAT', $idat) .
            self::pngChunk('IEND', '');
    }

    private static function pngChunk(string $type, string $data): string
    {
        return pack('N', strlen($data)) . $type . $data . pack('N', crc32($type . $data));
    }
}
