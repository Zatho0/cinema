<?php

namespace App\Http\Controllers;

use App\Models\Movie; // Importe le modèle
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        // On récupère TOUS les films de la table 'movies'
        $categories = \App\Models\Categories::with('movies')->get();
    // On prend un film au hasard pour la bannière du haut
        $heroMovie = \App\Models\Movie::inRandomOrder()->first();

        // On les envoie à la vue 'test-films'
        return view('test-films', compact('categories', 'heroMovie'));
    }
}