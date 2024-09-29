<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platillo extends Model
{
    use HasFactory;
    protected $table = 'PLATILLO';
    protected $fillable = ['NOMBRE_PLATILLO', 'PRECIO', 'DESCRIPCION', 'ID_CATEGORIA'];
}
