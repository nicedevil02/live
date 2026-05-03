<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class RequestAuditMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $startedAt = microtime(true);

        try {
            $response = $next($request);
        } catch (Throwable $e) {
            Log::error('HTTP request failed with exception', [
                'method' => $request->method(),
                'path' => $request->path(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_id' => $request->user()?->id,
                'status' => 500,
                'duration_ms' => round((microtime(true) - $startedAt) * 1000, 2),
                'exception' => $e::class,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }

        Log::info('HTTP request completed', [
            'method' => $request->method(),
            'path' => $request->path(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_id' => $request->user()?->id,
            'status' => $response->getStatusCode(),
            'duration_ms' => round((microtime(true) - $startedAt) * 1000, 2),
        ]);

        if ($response->getStatusCode() >= 500) {
            Log::error('HTTP request returned server error', [
                'method' => $request->method(),
                'path' => $request->path(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_id' => $request->user()?->id,
                'status' => $response->getStatusCode(),
                'duration_ms' => round((microtime(true) - $startedAt) * 1000, 2),
            ]);
        }

        return $response;
    }
}