<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $primaryKey = 'dui';
    public $timestamps = false;
    protected $fillable = [
        'dui',
        'first_name',
        'last_name',
        'address',
        'phone',
    ];
    public $incrementing = false;
    protected $keyType = 'string';
}
