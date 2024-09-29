<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;
    protected $table = 'DETALLE_PEDIDO';
    protected $fillable = ['ID_PLATILLO', 'ID_PEDIDO', 'CANTIDAD', 'SUBTOTAL'];
}
