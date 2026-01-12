<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Stock;
use App\Models\StockLog;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'table_number' => 'required|string|max:10',
            'payment_method' => 'required|in:cash,qris',
            'notes' => 'nullable|string|max:500',
            'menu_items' => 'required|array',
            'menu_items.*.menu_id' => 'required|exists:menus,id',
            'menu_items.*.qty' => 'required|integer|min:1',
        ]);

        // Hitung total
        $totalPrice = 0;
        foreach ($request->menu_items as $item) {
            $menu = Menu::findOrFail($item['menu_id']);
            $totalPrice += $menu->price * $item['qty'];
        }
        
        // Check stock availability first
        foreach ($request->menu_items as $item) {
            $menu = Menu::with('stock')->findOrFail($item['menu_id']);
            if ($menu->stock && $menu->stock->quantity < $item['qty']) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok {$menu->name} tidak mencukupi. Tersisa: {$menu->stock->quantity}"
                ], 422);
            }
        }

        DB::beginTransaction();
        try {
            // Generate unique order code
            $orderCode = 'ORD' . strtoupper(substr(uniqid() . bin2hex(random_bytes(3)), 0, 10));
            
            $order = Order::create([
                'order_code' => $orderCode,
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cash' ? 'paid' : 'pending',
                'notes' => $request->notes,
                'status' => 'diproses',
                'total_price' => $totalPrice,
            ]);

            foreach ($request->menu_items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);
                
                // Create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'price' => $menu->price,
                    'qty' => $item['qty'],
                    'subtotal' => $menu->price * $item['qty'],
                ]);
                
                // Deduct stock
                if ($menu->stock) {
                    $stock = $menu->stock;
                    $stock->quantity -= $item['qty'];
                    $stock->save();
                    
                    // Log stock change
                    StockLog::create([
                        'menu_id' => $menu->id,
                        'type' => 'OUT',
                        'qty' => $item['qty'],
                        'note' => "Order #{$order->order_code} - {$menu->name}"
                    ]);
                }
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true, 
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'total_price' => $totalPrice,
                'payment_method' => $request->payment_method
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Log error for debugging
            \Log::error('Order creation failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'customer' => $request->customer_name,
                'table' => $request->table_number
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pesanan. Silakan coba lagi atau hubungi admin.',
                'error_detail' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function show(Order $order)
    {
        $order->load('items.menu');
        return view('order.show', compact('order'));
    }

    public function track($orderCode)
    {
        $order = Order::with('items.menu')
            ->where('order_code', $orderCode)
            ->firstOrFail();
        
        return view('order.track', compact('order'));
    }
    
    public function checkStatus($orderCode)
    {
        $order = Order::where('order_code', $orderCode)->first();
        
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        
        return response()->json([
            'order_code' => $order->order_code,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'created_at' => $order->created_at->format('d/m/Y H:i')
        ]);
    }
}
