<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Tampilkan laporan penjualan di web
     */
    public function index(Request $request)
    {
        $period = $request->input('period', 'all'); // all, today, monthly, yearly
        $month = $request->input('month', date('Y-m'));
        $year = $request->input('year', date('Y'));
        
        $query = Order::with('items.menu')->orderBy('created_at', 'desc');
        
        // Filter berdasarkan periode
        switch($period) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'monthly':
                $query->whereYear('created_at', substr($month, 0, 4))
                      ->whereMonth('created_at', substr($month, 5, 2));
                break;
            case 'yearly':
                $query->whereYear('created_at', $year);
                break;
            // 'all' tidak perlu filter
        }
        
        $orders = $query->get();

        return view('admin.reports.sales', compact('orders', 'period', 'month', 'year'));
    }

    /**
     * Export laporan ke Excel (CSV)
     */
    public function exportExcel(Request $request)
    {
        $period = $request->input('period', 'all');
        $month = $request->input('month', date('Y-m'));
        $year = $request->input('year', date('Y'));
        
        $query = Order::with('items.menu')->orderBy('created_at', 'desc');
        
        switch($period) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'monthly':
                $query->whereYear('created_at', substr($month, 0, 4))
                      ->whereMonth('created_at', substr($month, 5, 2));
                break;
            case 'yearly':
                $query->whereYear('created_at', $year);
                break;
        }
        
        $orders = $query->get();
        
        $filename = 'laporan_penjualan_' . date('YmdHis') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
        
        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Kode Order', 'Tanggal', 'Status', 'Total']);
            
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_code,
                    $order->created_at->format('d/m/Y H:i'),
                    ucfirst($order->status),
                    'Rp ' . number_format($order->total_price, 0, ',', '.')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export laporan ke PDF
     */
    public function exportPdf(Request $request)
    {
        $period = $request->input('period', 'all');
        $month = $request->input('month', date('Y-m'));
        $year = $request->input('year', date('Y'));
        
        $query = Order::with('items.menu')->orderBy('created_at', 'desc');
        
        switch($period) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'monthly':
                $query->whereYear('created_at', substr($month, 0, 4))
                      ->whereMonth('created_at', substr($month, 5, 2));
                break;
            case 'yearly':
                $query->whereYear('created_at', $year);
                break;
        }
        
        $orders = $query->get();
        
        // Label periode untuk PDF
        $periodLabel = '';
        switch($period) {
            case 'today':
                $periodLabel = 'Hari Ini - ' . date('d/m/Y');
                break;
            case 'monthly':
                $periodLabel = 'Bulan ' . date('F Y', strtotime($month . '-01'));
                break;
            case 'yearly':
                $periodLabel = 'Tahun ' . $year;
                break;
            default:
                $periodLabel = 'Semua Periode';
        }

        $pdf = Pdf::loadView('admin.reports.sales_pdf', compact('orders', 'periodLabel'));

        return $pdf->download('laporan_penjualan_' . $period . '.pdf');
    }
}
