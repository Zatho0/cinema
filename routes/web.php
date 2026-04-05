<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CartController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Route pour afficher les films
Route::get('/films', [App\Http\Controllers\MovieController::class, 'index'])-> name('films.index');
Route::get('/categories/{slug}', [MovieController::class, 'category'])->name('films.categories');
Route::get('/movie/{id}', [MovieController::class, 'show'])->name('films.show');
Route::get('/director/{name}', [MovieController::class, 'director'])->name('films.director');



Route::middleware(['auth'])->group(function () {
    Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
    Route::post('/panier/ajouter', [CartController::class, 'store'])->name('cart.add');
    Route::delete('/panier/supprimer/{id}', [CartController::class, 'destroy'])->name('cart.remove');
    Route::post('/panier/vider', [CartController::class, 'clear'])->name('cart.clear');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});