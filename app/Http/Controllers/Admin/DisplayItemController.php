<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisplayItem;
use Illuminate\Http\Request;

class DisplayItemController extends Controller
{
    /**
     * نمایش لیست آیتم‌ها
     */
    public function index()
    {
        $items = DisplayItem::where('user_id', auth()->id())->orderBy('order')->get();

        if (request()->expectsJson()) {
            return response()->json($items);
        }

        return view('admin.display-items.index', compact('items'));
    }

    /**
     * به‌روزرسانی ترتیب و وضعیت آیتم‌ها
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'items'                  => 'required|array',
            'items.*.key'            => 'required|string',
            'items.*.enabled'        => 'required|boolean',
            'items.*.order'          => 'required|integer',
            'items.*.label'          => 'sometimes|string',
        ]);

        foreach ($data['items'] as $item) {
            DisplayItem::where('user_id', auth()->id())->where('key', $item['key'])->update([
                'enabled' => $item['enabled'],
                'order'   => $item['order'],
            ]);
        }

        return response()->json(DisplayItem::where('user_id', auth()->id())->orderBy('order')->get());
    }
}