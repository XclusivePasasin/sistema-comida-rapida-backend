<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;
    protected $fillable = ['password', 'role', 'username', 'employee_name', 'phone'];
}
    