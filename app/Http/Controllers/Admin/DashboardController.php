<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $username = auth()->user()->username;
        return view('admin.dashboard', compact('username'));
    }
}