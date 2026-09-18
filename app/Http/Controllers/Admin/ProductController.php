<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSlide;
use App\Models\ProductImage;
use App\Models\AuditLog;
use App\Models\MarketCache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $latestGoldPrice = MarketCache::where('symbol', 'gold18')->first()->value ?? 0;
        $products = ProductSlide::where('user_id', auth()->id())->with('images')->latest()->get();

        // اگر درخواست JSON بود (برای Alpine.js)
        if (request()->wantsJson()) {
            $products->transform(function($p) use ($latestGoldPrice) {
                $base = ($latestGoldPrice * $p->weight_gram);
                $profit = $p->profit_type === 'percent' ? ($base * ($p->profit_value / 100)) : (float)$p->profit_value;
                $p->final_price = round($base + $profit);
                return $p;
            });
            return response()->json($products);
        }

        return view('admin.products.index', compact('products', 'latestGoldPrice'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:255',
            'weight_gram'     => 'required|numeric|min:0',
            'profit_value'    => 'required|numeric|min:0',
            'profit_type'     => 'required|in:percent,amount',
            'image_file'      => 'nullable|image|max:2048',
        ]);

        $latestGoldPrice = MarketCache::where('symbol', 'gold18')->first()->value ?? 0;
        $base = ($latestGoldPrice * $data['weight_gram']);
        $profit = $data['profit_type'] === 'percent' ? ($base * ($data['profit_value'] / 100)) : (float)$data['profit_value'];
        $finalPrice = round($base + $profit);

        $product = ProductSlide::create([
            'id'              => 'p-' . now()->timestamp . rand(10, 99),
            'user_id'         => auth()->id(),
            'title'           => $data['title'],
            'weight_gram'     => $data['weight_gram'],
            'labor_fee'       => 0,
            'profit_value'    => $data['profit_value'],
            'profit_type'     => $data['profit_type'],
            'base_gold_price' => $latestGoldPrice,
            'final_price'     => $finalPrice,
            'is_visible'      => true,
        ]);

        if ($request->hasFile('image_file')) {
            $userId = auth()->id();
            $path = $this->optimizeAndStoreProductImage($request->file('image_file'), $userId);
            $product->images()->create([
                'id' => 'img-' . uniqid(),
                'url' => '/storage/' . $path,
                'alt' => $data['title'],
                'sort_order' => 1
            ]);
        } elseif ($request->filled('image_url')) {
            $product->images()->create([
                'id' => 'img-' . uniqid(),
                'url' => $request->image_url,
                'alt' => $data['title'],
                'sort_order' => 1
            ]);
        }

        return response()->json($product->load('images'), 201);
    }

    public function update(Request $request, $id)
    {
        $product = ProductSlide::where('user_id', auth()->id())->findOrFail($id);
        $data = $request->validate([
            'title'        => 'sometimes|string',
            'weight_gram'  => 'sometimes|numeric',
            'profit_value' => 'sometimes|numeric',
            'profit_type'  => 'sometimes|in:percent,amount',
            'is_visible'   => 'sometimes|boolean',
        ]);

        $product->update($data);

        // محاسبه مجدد قیمت برای پاسخ JSON
        $latestGoldPrice = MarketCache::where('symbol', 'gold18')->first()->value ?? 0;
        $base = ($latestGoldPrice * $product->weight_gram);
        $profit = $product->profit_type === 'percent' ? ($base * ($product->profit_value / 100)) : (float)$product->profit_value;
        $product->final_price = round($base + $profit);

        return response()->json($product->load('images'));
    }

    public function destroy($id)
    {
        $product = ProductSlide::where('user_id', auth()->id())->findOrFail($id);
        $product->delete();
        return response()->json(['ok' => true]);
    }

    public function addImageUrl(Request $request, $id)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        // جلوگیری از سوءاستفاده با ارسال آدرس‌های محلی استوریج سرور
        if (str_contains($request->url, '/storage/')) {
            return response()->json(['message' => 'ثبت آدرس فایل‌های داخلی مجاز نیست. لطفاً از دکمه آپلود فایل استفاده کنید.'], 422);
        }

        $product = ProductSlide::where('user_id', auth()->id())->findOrFail($id);
        $img = $product->images()->create([
            'id' => 'img-' . uniqid(),
            'url' => $request->url,
            'alt' => $product->title,
            'sort_order' => $product->images()->count() + 1
        ]);
        return response()->json($img);
    }

    public function uploadImageFile(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);
        $userId = auth()->id();
        $product = ProductSlide::where('user_id', $userId)->findOrFail($id);
        $path = $this->optimizeAndStoreProductImage($request->file('image'), $userId);
        $img = $product->images()->create([
            'id' => 'img-' . uniqid(),
            'url' => '/storage/' . $path,
            'alt' => $product->title,
            'sort_order' => $product->images()->count() + 1
        ]);
        return response()->json($img);
    }

    public function deleteImage($id, $imageId)
    {
        $userId = auth()->id();
        $img = ProductImage::whereHas('product', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('product_id', $id)->where('id', $imageId)->firstOrFail();

        // حذف امن فایل فقط در صورتی که در پوشه اختصاصی همین کاربر باشد
        $userPrefix = "/storage/products/{$userId}/";
        if (str_starts_with($img->url, $userPrefix)) {
            $storagePath = str_replace('/storage/', '', $img->url);
            if (Storage::disk('public')->exists($storagePath)) {
                Storage::disk('public')->delete($storagePath);
            }
        }

        $img->delete();
        return response()->json(['ok' => true]);
    }

    /**
     * بهینه‌سازی، فشرده‌سازی و تبدیل خودکار تصاویر آپلودی محصولات به فرمت بهینه WebP
     */
    protected function optimizeAndStoreProductImage($file, $userId): string
    {
        $dir = storage_path("app/public/products/{$userId}");
        if (!file_exists($dir)) {
            @mkdir($dir, 0755, true);
        }

        $filename = 'prod_' . time() . '_' . Str::random(8) . '.webp';
        $targetPath = $dir . DIRECTORY_SEPARATOR . $filename;

        // در صورت پشتیبانی سرور از توابع GD و WebP
        if (extension_loaded('gd') && function_exists('imagewebp')) {
            try {
                $realPath = $file->getRealPath();
                $imageInfo = @getimagesize($realPath);
                if ($imageInfo) {
                    $mime = $imageInfo['mime'];
                    $src = null;
                    if ($mime === 'image/jpeg') {
                        $src = @imagecreatefromjpeg($realPath);
                    } elseif ($mime === 'image/png') {
                        $src = @imagecreatefrompng($realPath);
                    } elseif ($mime === 'image/webp') {
                        $src = @imagecreatefromwebp($realPath);
                    }

                    if ($src) {
                        $origW = imagesx($src);
                        $origH = imagesy($src);
                        $maxW = 1200;

                        if ($origW > $maxW) {
                            $newW = $maxW;
                            $newH = (int) round(($origH * $maxW) / $origW);
                            $dst = imagecreatetruecolor($newW, $newH);
                            // حفظ شفافیت در صورت وجود لایه آلفا
                            imagealphablending($dst, false);
                            imagesavealpha($dst, true);
                            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
                            imagedestroy($src);
                            $src = $dst;
                        }

                        imagewebp($src, $targetPath, 82);
                        imagedestroy($src);

                        return "products/{$userId}/{$filename}";
                    }
                }
            } catch (\Throwable $e) {
                // در صورت بروز هرگونه استثنا، ذخیره‌سازی استاندارد لاراول صورت گیرد
            }
        }

        // روش پیش‌فرض و ایمن لاراول
        return $file->store("products/{$userId}", 'public');
    }
}
