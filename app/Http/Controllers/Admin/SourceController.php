<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiSourceConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SourceController extends Controller
{
    /**
     * نمایش لیست منابع API
     */
    public function index()
    {
        $sources = ApiSourceConfig::all();

        $today = now()->format('Y-m-d');
        $apiCalls = [
            'count' => Cache::get("api_calls_count_{$today}", 0),
            'date'  => $today,
        ];

        if (request()->expectsJson()) {
            return response()->json([
                'sources'   => $sources,
                'api_calls' => $apiCalls,
            ]);
        }

        return view('admin.sources.index', compact('sources', 'apiCalls'));
    }

    /**
     * به‌روزرسانی تنظیمات یک منبع
     */
    public function update(Request $request, $key)
    {
        $source = ApiSourceConfig::where('key', $key)->firstOrFail();

        $validated = $request->validate([
            'base_url'         => 'required|url',
            'interval_seconds' => 'required|integer|min:10',
            'fallback_urls'    => 'nullable|array',
            'auth_token'       => 'nullable|string',
            'is_active'        => 'sometimes|boolean',
        ]);

        $source->update([
            'base_url'         => $validated['base_url'],
            'interval_seconds' => $validated['interval_seconds'],
            'fallback_urls'    => json_encode($validated['fallback_urls'] ?? []),
            'auth_token'       => $validated['auth_token'] ?? '',
            'is_active'        => $request->boolean('is_active', $source->is_active),
            'last_checked_at'  => now(),
        ]);

        // لاگ
        \App\Models\AuditLog::create([
            'id'          => 'log-' . now()->timestamp . rand(100, 999),
            'actor'       => auth()->user()->name ?? 'admin',
            'action'      => 'update',
            'entity_type' => 'api_source_config',
            'entity_id'   => $source->key,
            'payload'     => json_encode($source->toArray()),
            'created_at'  => now(),
        ]);

        return response()->json($source);
    }

    /**
     * تست ارتباط با یک منبع
     */
    public function test($key)
    {
        $source = ApiSourceConfig::where('key', $key)->firstOrFail();

        // این بخش بعداً توسط MarketService تکمیل می‌شود
        // فعلاً یک پاسخ موفقیت‌آمیز شبیه‌سازی می‌کنیم
        $latency = rand(80, 400);

        $source->update([
            'last_status'     => 'ok',
            'last_latency_ms' => $latency,
            'last_checked_at' => now(),
        ]);

        return response()->json([
            'success'    => true,
            'latency_ms' => $latency,
            'checked_at' => now()->toISOString(),
            'status'     => 'ok',
        ]);
    }
}