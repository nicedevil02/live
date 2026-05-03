<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;

class LogController extends Controller
{
    /**
     * نمایش لیست لاگ‌ها
     */
    public function index()
    {
        $logs = AuditLog::latest('created_at')->limit(100)->get();

        if (request()->expectsJson()) {
            return response()->json($logs);
        }

        return view('admin.logs.index', compact('logs'));
    }
}
