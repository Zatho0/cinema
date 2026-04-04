<?php

namespace App\Http\Controllers;

use App\Models\Movie; // Importe le modèle
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        // On récupère TOUS les films de la table 'movies'
        $movies = Movie::all();

        // On les envoie à la vue 'test-films'
        return view('test-films', compact('movies'));
    }
}