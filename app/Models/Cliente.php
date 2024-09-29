<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'CLIENTE';
    protected $primaryKey = 'DUI';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['DUI', 'NOMBRE', 'APELLIDO', 'DIRECCION', 'TELEFONO'];
}
