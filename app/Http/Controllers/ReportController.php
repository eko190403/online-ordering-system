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
        
        // Expense Query
        $expenseQuery = \App\Models\Expense::orderBy('expense_date', 'desc');
        switch($period) {
            case 'today':
                $expenseQuery->whereDate('expense_date', today());
                break;
            case 'monthly':
                $expenseQuery->whereYear('expense_date', substr($month, 0, 4))
                      ->whereMonth('expense_date', substr($month, 5, 2));
                break;
            case 'yearly':
                $expenseQuery->whereYear('expense_date', $year);
                break;
        }
        $expenses = $expenseQuery->get();

        return view('admin.reports.sales', compact('orders', 'expenses', 'period', 'month', 'year'));
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
        
        // Expense Query
        $expenseQuery = \App\Models\Expense::orderBy('expense_date', 'desc');
        switch($period) {
            case 'today':
                $expenseQuery->whereDate('expense_date', today());
                break;
            case 'monthly':
                $expenseQuery->whereYear('expense_date', substr($month, 0, 4))
                      ->whereMonth('expense_date', substr($month, 5, 2));
                break;
            case 'yearly':
                $expenseQuery->whereYear('expense_date', $year);
                break;
        }
        $expenses = $expenseQuery->get();
        
        $filename = 'laporan_keuangan_' . date('YmdHis') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
        
        $callback = function() use ($orders, $expenses) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['=== PEMASUKAN ===']);
            fputcsv($file, ['Kode Order', 'Tanggal', 'Status', 'Total']);
            
            $totalRevenue = 0;
            foreach ($orders as $order) {
                // Gunakan final total yang sudah dipotong diskon
                $finalPrice = $order->total_price - $order->discount_amount;
                $totalRevenue += $finalPrice;
                fputcsv($file, [
                    $order->order_code,
                    $order->created_at->format('d/m/Y H:i'),
                    ucfirst($order->status),
                    'Rp ' . number_format($finalPrice, 0, ',', '.')
                ]);
            }
            fputcsv($file, ['', '', 'TOTAL PEMASUKAN', 'Rp ' . number_format($totalRevenue, 0, ',', '.')]);
            
            fputcsv($file, []);
            fputcsv($file, ['=== PENGELUARAN ===']);
            fputcsv($file, ['Kategori', 'Tanggal', 'Deskripsi', 'Total']);
            
            $totalExpense = 0;
            foreach ($expenses as $expense) {
                $totalExpense += $expense->amount;
                fputcsv($file, [
                    $expense->category,
                    $expense->expense_date->format('d/m/Y'),
                    $expense->description,
                    'Rp ' . number_format($expense->amount, 0, ',', '.')
                ]);
            }
            fputcsv($file, ['', '', 'TOTAL PENGELUARAN', 'Rp ' . number_format($totalExpense, 0, ',', '.')]);
            
            fputcsv($file, []);
            fputcsv($file, ['=== RINGKASAN ===']);
            fputcsv($file, ['LABA BERSIH', '', '', 'Rp ' . number_format($totalRevenue - $totalExpense, 0, ',', '.')]);
            
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
        
        // Expense Query
        $expenseQuery = \App\Models\Expense::orderBy('expense_date', 'desc');
        switch($period) {
            case 'today':
                $expenseQuery->whereDate('expense_date', today());
                break;
            case 'monthly':
                $expenseQuery->whereYear('expense_date', substr($month, 0, 4))
                      ->whereMonth('expense_date', substr($month, 5, 2));
                break;
            case 'yearly':
                $expenseQuery->whereYear('expense_date', $year);
                break;
        }
        $expenses = $expenseQuery->get();
        
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

        $pdf = Pdf::loadView('admin.reports.sales_pdf', compact('orders', 'expenses', 'periodLabel'));

        return $pdf->download('laporan_keuangan_' . $period . '.pdf');
    }
}
