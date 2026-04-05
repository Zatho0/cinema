<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    // Indique les colonnes que Laravel a le droit de remplir
    protected $fillable = [
        'name', 
        'description', 
        'poster', 
        'price', 
        'categories_id', 
        'director'
    ];

    // La relation pour récupérer la catégorie du film
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}