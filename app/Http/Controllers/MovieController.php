<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Categories; 
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        
        $search = $request->query('search');

        
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

        
       
        $heroMovie = null;
        if (!$search) {
            $heroMovie = Movie::inRandomOrder()->first();
        }

        
        return view('test-films', compact('categories', 'heroMovie', 'search'));
    }
    public function category($slug, Request $request)
{
   
    
    $category = \App\Models\Categories::with(['movies' => function($query) use ($request) {
        $search = $request->query('search');
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('director', 'LIKE', "%{$search}%");
        }
    }])->where('name', $slug)->firstOrFail();

   
    $categories = collect([$category]);

  
    $heroMovie = $category->movies->first();

    return view('test-films', compact('categories', 'heroMovie'));
}

    public function show($id)
    {
        $movie = \App\Models\Movie::findOrFail($id);
        
       
        $similarMovies = \App\Models\Movie::where('categories_id', $movie->category_id)
                            ->where('id', '!=', $movie->id)
                            ->take(6)
                            ->get();

        return view('films-show', compact('movie', 'similarMovies'));
    }

    public function director($name)
    {
        $movies = \App\Models\Movie::where('director', $name)->get();
        $categories = collect([
            (object) ['name' => "Films réalisés par " . $name, 'movies' => $movies]
        ]);
        
        $heroMovie = $movies->first();
        return view('test-films', compact('categories', 'heroMovie'));
    }
}