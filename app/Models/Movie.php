<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    
    protected $fillable = [
        'name', 
        'description', 
        'poster', 
        'price', 
        'categories_id', 
        'director'
    ];

   
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}