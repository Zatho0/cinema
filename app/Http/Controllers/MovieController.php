<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Categories; // Assure-toi que le nom du modèle est bien 'Categories' (souvent c'est Category)
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        // 1. On récupère le mot-clé depuis l'URL 
        $search = $request->query('search');

        // 2. On récupère les catégories avec leurs films, en filtrant si une recherche existe
        $categories = Categories::with(['movies' => function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('director', 'LIKE', "%{$search}%");
            }
        }])
        ->whereHas('movies', function ($query) use ($search) {
            if ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('director', 'LIKE', "%{$search}%");
            }
        })
        ->get();

        // 3. Gestion du HeroMovie : On le cache si on fait une recherche pour laisser place aux résultats
        // Ou on garde un film au hasard si aucune recherche n'est faite.
        $heroMovie = null;
        if (!$search) {
            $heroMovie = Movie::inRandomOrder()->first();
        }

        // On envoie tout à la vue
        return view('test-films', compact('categories', 'heroMovie', 'search'));
    }
    public function category($slug, Request $request)
{
    // 1. On cherche la catégorie par son nom (ou slug si tu en as un)
    // On utilise 'where' pour autoriser "Action" ou "Drame" dans l'URL
    $category = \App\Models\Categories::with(['movies' => function($query) use ($request) {
        $search = $request->query('search');
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('director', 'LIKE', "%{$search}%");
        }
    }])->where('name', $slug)->firstOrFail();

    // 2. On transforme l'unique catégorie en collection pour que la vue @foreach continue de fonctionner
    $categories = collect([$category]);

    // 3. On prend un HeroMovie spécifique à cette catégorie pour l'ambiance
    $heroMovie = $category->movies->first();

    return view('test-films', compact('categories', 'heroMovie'));
}
}