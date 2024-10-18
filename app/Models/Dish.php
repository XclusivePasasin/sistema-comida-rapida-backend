<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $table = 'dishes';
    public $timestamps = false;
    protected $primaryKey = 'id_dish';
    protected $fillable = [
        'dish_name',
        'price',
        'description',
        'id_category',
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id_category');
    }
}
