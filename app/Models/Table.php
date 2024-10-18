<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;
    protected $table = 'tables';
    protected $primaryKey = 'id_table';
    public $timestamps = false;
    protected $fillable = [
        'table_number',
    ];
}
