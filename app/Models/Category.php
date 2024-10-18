<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
     protected $table = 'categories';
     public $timestamps = false;
     protected $primaryKey = 'id_category';
     protected $fillable = [
         'name',
     ];
}
