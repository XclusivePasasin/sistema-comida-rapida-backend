<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'USUARIO';
    protected $fillable = ['USUARIO', 'CONTRASEÑA', 'ROL', 'NOMBRE_EMPLEADO', 'TELEFONO'];
}
