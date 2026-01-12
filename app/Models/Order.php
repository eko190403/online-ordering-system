<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'customer_name',
        'table_number',
        'payment_method',
        'payment_status',
        'notes',
        'status',
        'total_price',
    ];

    // Relasi ke order_items
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}