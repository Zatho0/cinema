<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Afficher le panier
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('movie')->get();
        
        // Calcul du montant total 
        $total = $cartItems->sum(function($item) {
            return $item->movie->price * $item->quantity;
        });

        return view('cart', compact('cartItems', 'total'));
    }

    // Ajouter un film
    public function store(Request $request)
    {
        
        Cart::firstOrCreate([
            'user_id'  => auth()->id(),
            'movie_id' => $request->movie_id
        ]);

        return redirect()->back()->with('success', 'Ajouté au panier !');
    }

    // Supprimer un article spécifique
    public function destroy($id)
    {
        Cart::where('user_id', Auth::id())->where('id', $id)->delete();
        return redirect()->back();
    }

    // Vider tout le panier
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();
        return redirect()->back();
    }
}