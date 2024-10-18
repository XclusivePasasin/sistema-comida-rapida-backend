<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detail_order extends Model
{
    protected $table = 'order_detail';
    protected $primaryKey = 'id_order_detail';
    public $timestamps = false;
    protected $fillable = [
        'id_dish',
        'id_order',
        'quantity',
        'subtotal',
    ];

    public function dish()
    {
        return $this->belongsTo(Dish::class, 'id_dish', 'id_dish');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }
}
