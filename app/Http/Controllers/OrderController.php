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
            'promo_id' => 'nullable|exists:promos,id',
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
        
        // Calculate Discount
        $discountAmount = 0;
        if ($request->promo_id) {
            $promo = \App\Models\Promo::find($request->promo_id);
            if ($promo && $promo->is_active && $totalPrice >= $promo->min_purchase) {
                if ($promo->discount_type == 'percent') {
                    $discountAmount = ($promo->discount_amount / 100) * $totalPrice;
                } else {
                    $discountAmount = $promo->discount_amount;
                }
                if ($discountAmount > $totalPrice) {
                    $discountAmount = $totalPrice;
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Promo tidak valid.'], 422);
            }
        }
        
        $finalPrice = $totalPrice - $discountAmount;
        $pointsEarned = 0;
        
        // Calculate points if customer is logged in (Rp 100 = 1 point)
        $userId = auth('web')->check() && auth('web')->user()->role == 'customer' ? auth('web')->id() : null;
        if ($userId) {
            $pointsEarned = floor($finalPrice / 100);
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
                'user_id' => $userId,
                'customer_name' => $request->customer_name,
                'table_number' => $request->table_number,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cash' ? 'paid' : 'pending',
                'notes' => $request->notes,
                'status' => 'diproses',
                'total_price' => $totalPrice,
                'promo_id' => $request->promo_id,
                'discount_amount' => $discountAmount,
                'points_earned' => $pointsEarned,
            ]);
            
            if ($userId && $pointsEarned > 0) {
                $user = \App\Models\User::find($userId);
                $user->points += $pointsEarned;
                $user->save();
            }

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
            
            $snapToken = null;
            if ($request->payment_method === 'qris') {
                $serverKey = config('midtrans.server_key');
                
                // Jika kunci Midtrans belum disetting, gunakan dummy
                if (!$serverKey || strpos($serverKey, 'YOUR_SERVER_KEY') !== false) {
                    $snapToken = 'dummy_token';
                    
                    // Otomatis tandai lunas untuk simulasi agar masuk ke KDS
                    $order->payment_status = 'paid';
                    $order->save();
                } else {
                    // Set Midtrans configuration
                    \Midtrans\Config::$serverKey = $serverKey;
                    \Midtrans\Config::$isProduction = config('midtrans.is_production');
                    \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
                    \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

                    $params = [
                        'transaction_details' => [
                            'order_id' => $order->order_code,
                            'gross_amount' => $finalPrice,
                        ],
                        'customer_details' => [
                            'first_name' => $request->customer_name,
                        ],
                    ];

                    try {
                        $snapToken = \Midtrans\Snap::getSnapToken($params);
                    } catch (\Exception $e) {
                        \Log::error('Midtrans Snap Error: ' . $e->getMessage());
                        $snapToken = 'dummy_token'; // Fallback
                    }
                }
            }
            
            return response()->json([
                'success' => true, 
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'total_price' => $totalPrice,
                'payment_method' => $request->payment_method,
                'snap_token' => $snapToken
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
