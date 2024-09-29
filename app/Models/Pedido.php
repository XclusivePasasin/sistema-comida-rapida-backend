<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'PEDIDO';
    protected $fillable = ['ID_USUARIO', 'FECHA', 'DUI_CLIENTE', 'ID_MESA', 'ESTADO', 'TOTAL', 'PAGO'];
}
