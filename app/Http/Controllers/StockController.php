<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\StockLog;
use App\Models\Menu;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('menu')->get();
        $menus = Menu::all();
        return view('admin.stock.index', compact('stocks', 'menus'));
    }

    public function toggleStock(Request $request, Menu $menu)
    {
        $request->validate([
            'status' => 'required|in:tersedia,habis',
            'note' => 'nullable|string'
        ]);

        // Cek atau buat stock untuk menu ini
        $stock = Stock::firstOrCreate(
            ['menu_id' => $menu->id],
            ['quantity' => 0]
        );

        $oldQty = $stock->quantity;
        
        // Set quantity berdasarkan status
        if ($request->status === 'tersedia') {
            $stock->quantity = 100; // Set stok tersedia (angka default)
            $type = 'IN';
            $qty = 100;
        } else {
            $stock->quantity = 0; // Set stok habis
            $type = 'OUT';
            $qty = $oldQty;
        }
        $stock->save();

        // Catat log
        StockLog::create([
            'menu_id' => $menu->id,
            'type' => $type,
            'qty' => abs($qty),
            'note' => $request->note ?? "Status diubah menjadi: {$request->status}"
        ]);

        return redirect()->back()->with('success', "Status stok {$menu->name} berhasil diubah menjadi {$request->status}!");
    }

    public function updateStock(Request $request, Menu $menu)
    {
        $request->validate([
            'type' => 'required|in:IN,OUT',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string'
        ]);

        // Cek atau buat stock untuk menu ini
        $stock = Stock::firstOrCreate(
            ['menu_id' => $menu->id],
            ['quantity' => 0]
        );

        // Update quantity
        if ($request->type === 'IN') {
            $stock->quantity += $request->qty;
        } else {
            $stock->quantity -= $request->qty;
            if ($stock->quantity < 0) {
                return redirect()->back()->with('error', 'Stok tidak cukup!');
            }
        }
        $stock->save();

        // Catat log
        StockLog::create([
            'menu_id' => $menu->id,
            'type' => $request->type,
            'qty' => $request->qty,
            'note' => $request->note
        ]);

        return redirect()->back()->with('success', 'Stok berhasil diupdate!');
    }

    public function logs()
    {
        $logs = StockLog::with('menu')->orderBy('created_at', 'desc')->paginate(50);
        return view('admin.stock.logs', compact('logs'));
    }
}
