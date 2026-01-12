<?php

namespace App\Repositories;

use App\Models\Order;

class SalesReportRepository
{
    /**
     * Ambil data laporan penjualan
     * 
     * @param string $startDate (YYYY-MM-DD)
     * @param string $endDate   (YYYY-MM-DD)
     */
    public static function get($startDate, $endDate)
    {
        // Validasi kasar biar nggak ngaco
        if (!$startDate || !$endDate) {
            return collect();
        }

        return Order::with('items.menu')
            ->where('status', 'selesai')
            ->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ])
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
