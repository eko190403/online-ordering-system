<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class KitchenController extends Controller
{
    public function index()
    {
        return view('kitchen.index');
    }

    public function getActiveOrders()
    {
        $orders = Order::with('items.menu')
            ->where('status', 'diproses')
            ->where(function($q) {
                $q->where('payment_status', 'paid')
                  ->orWhere('payment_method', 'cash'); 
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($orders);
    }

    public function completeOrder($id)
    {
        $order = Order::with('user')->findOrFail($id);
        $order->status = 'selesai';
        $order->save();
        
        // WA Simulation
        if ($order->user && $order->user->phone) {
            $msg = "[WHATSAPP SIMULATION] To: {$order->user->phone} - Hore! Pesanan Anda #{$order->order_code} sudah SELESAI disiapkan dan siap dihidangkan.";
            \Illuminate\Support\Facades\Log::channel('single')->info($msg);
        }

        return response()->json(['success' => true]);
    }
}
