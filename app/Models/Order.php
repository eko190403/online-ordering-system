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
        'user_id',
        'promo_id',
        'total_price',
        'discount_amount',
        'points_earned',
        'payment_method',
        'payment_status',
        'notes',
        'snap_token',
        'status',
    ];

    // Relasi ke order_items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }
}