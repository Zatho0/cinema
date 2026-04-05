<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categories extends Model
{
    protected $fillable = ['name', 'slug'];

    /**
     * Une catégorie possède plusieurs films.
     */
    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class);
    }
}