<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'type',
        'qty',
        'note',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
