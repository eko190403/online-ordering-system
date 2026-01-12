<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Order::with('items.menu')->get()->map(function($order){
            return $order->items->map(function($item) use($order){
                return [
                    'order_code' => $order->order_code,
                    'status' => $order->status,
                    'menu_name' => $item->menu->name ?? '-',
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                    'created_at' => $order->created_at,
                ];
            });
        })->flatten(1);
    }

    public function headings(): array
    {
        return ['Order Code', 'Status', 'Menu', 'Qty', 'Price', 'Subtotal', 'Created At'];
    }
}
