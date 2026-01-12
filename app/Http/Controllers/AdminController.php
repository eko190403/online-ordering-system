<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Category;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        $totalOrders = Order::count();
        $ordersMasuk = Order::where('status', 'masuk')->count();
        $ordersDiproses = Order::where('status', 'diproses')->count();
        $ordersSelesai = Order::where('status', 'selesai')->count();
        $totalMenus = Menu::count();
        $totalCategories = Category::count();
        
        // Total Revenue
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_price');
        $todayRevenue = Order::where('payment_status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_price');
        
        // Menu Terlaris (Top 5)
        $topMenus = OrderItem::select('menu_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('menu_id')
            ->orderBy('total_qty', 'desc')
            ->with('menu')
            ->limit(5)
            ->get();
        
        // Revenue Trend (7 hari terakhir)
        $revenueTrend = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as revenue'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        
        // Peak Hours (order count per hour)
        $peakHours = Order::select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 
            'ordersMasuk', 
            'ordersDiproses', 
            'ordersSelesai',
            'totalMenus',
            'totalCategories',
            'totalRevenue',
            'todayRevenue',
            'topMenus',
            'revenueTrend',
            'peakHours'
        ));
    }

    // ORDERS
    public function index()
    {
        $orders = Order::with('items.menu')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:masuk,diproses,selesai'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', "Status order {$order->order_code} diubah menjadi {$order->status}");
    }

    public function confirmPayment($id)
    {
        $order = Order::findOrFail($id);
        
        if ($order->payment_status == 'paid') {
            return redirect()->back()->with('info', 'Pembayaran sudah dikonfirmasi sebelumnya.');
        }
        
        $order->payment_status = 'paid';
        $order->save();

        return redirect()->back()->with('success', "Pembayaran order {$order->order_code} telah dikonfirmasi.");
    }

    public function printOrder($id)
    {
        $order = Order::with('items.menu')->findOrFail($id);
        return view('admin.orders.print', compact('order'));
    }

    // QR CODE
    public function qrCode()
    {
        $url = 'http://192.168.1.9:8000/menu';
        
        // Generate QR Code menggunakan API gratis dari api.qrserver.com
        $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($url);
        
        return view('admin.qrcode', compact('qrCodeUrl', 'url'));
    }
}
