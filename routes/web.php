<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/*

 Routes Publiques

*/


Route::get('/', function () {
    return redirect()->route('login');
});

/*

 Routes Protégées (Nécessite d'être connecté)

*/
Route::middleware(['auth', 'verified'])->group(function () {

    //  CATALOGUE DE FILMS 
    Route::get('/films', [MovieController::class, 'index'])->name('films.index');
    Route::get('/categories/{slug}', [MovieController::class, 'category'])->name('films.categories');
    Route::get('/movie/{id}', [MovieController::class, 'show'])->name('films.show');
    Route::get('/director/{name}', [MovieController::class, 'director'])->name('films.director');

    //  PANIER 
    Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
    Route::post('/panier/ajouter', [CartController::class, 'store'])->name('cart.add');
    Route::delete('/panier/supprimer/{id}', [CartController::class, 'destroy'])->name('cart.remove');
    Route::post('/panier/vider', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/panier/payer', [CartController::class, 'checkout'])->name('cart.checkout');

    // PROFIL & SÉCURITÉ 
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // Routes par défaut de Laravel Breeze
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*

 Authentification (Login, Register, etc...)

*/
require __DIR__.'/auth.php';