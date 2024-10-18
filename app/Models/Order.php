<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'order_date',
        'customer_dui',
        'id_table',
        'status',
        'total',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_dui', 'dui');
    }

    public function table()
    {
        return $this->belongsTo(Table::class, 'id_table', 'id_table');
    }
}
