<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - Cinema</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#141414] text-white font-sans antialiased">

    <!-- Header simple -->
    <nav class="p-6 flex justify-between items-center border-b border-white/10">
        <a href="{{ route('films.index') }}" class="text-red-600 text-2xl font-black uppercase italic tracking-tighter">Cinema</a>
        <a href="{{ route('films.index') }}" class="text-sm text-gray-400 hover:text-white transition">Continuer mes achats</a>
    </nav>

    <div class="container mx-auto px-4 md:px-12 py-12">
        <div class="flex justify-between items-end mb-10">
            <h1 class="text-4xl md:text-5xl font-black uppercase italic">Votre Panier</h1>
            @if($cartItems->count() > 0)
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-xs text-red-500 hover:underline uppercase font-bold tracking-widest">Vider le panier</button>
                </form>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Liste des films -->
            <div class="lg:col-span-2 space-y-4">
                @forelse($cartItems as $item)
                <div class="flex items-center bg-white/5 p-4 rounded-sm border border-white/10 group transition hover:border-red-600/50">
                    <img src="{{ $item->movie->poster }}" class="w-16 h-24 object-cover rounded shadow-lg" alt="">
                    
                    <div class="ml-6 flex-1">
                        <h2 class="text-lg font-bold uppercase tracking-tight">{{ $item->movie->name }}</h2>
                        <p class="text-gray-500 text-xs italic">{{ $item->movie->director }}</p>
                    </div>

                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xl font-black text-green-400">{{ number_format($item->movie->price, 2) }} €</span>
                        
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-[10px] text-gray-500 hover:text-white uppercase font-bold tracking-tighter bg-white/5 px-2 py-1 rounded transition">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="py-20 text-center border-2 border-dashed border-white/10 rounded-lg">
                    <p class="text-gray-500 text-lg italic">Rien ici pour le moment... 🍿</p>
                    <a href="{{ route('films.index') }}" class="inline-block mt-6 bg-red-600 px-8 py-3 font-bold uppercase text-sm">Découvrir les films</a>
                </div>
                @endforelse
            </div>

            <!-- Résumé  -->
            <div class="relative">
                <div class="bg-white text-black p-8 rounded-sm sticky top-24">
                    <h2 class="text-2xl font-black uppercase italic mb-6">Total</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between border-b border-black/10 pb-2">
                            <span class="text-sm uppercase font-bold text-gray-600">Articles</span>
                            <span class="font-bold">{{ $cartItems->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-4">
                            <span class="text-sm uppercase font-bold text-gray-600">Montant à régler</span>
                            <span class="text-3xl font-black">{{ number_format($total, 2) }} €</span>
                        </div>
                    </div>

                    <button class="w-full mt-8 bg-red-600 text-white py-4 font-black uppercase tracking-widest hover:bg-black transition-colors shadow-xl active:scale-95 transform">
                        Payer maintenant
                    </button>

                    <p class="text-[9px] text-gray-400 mt-4 text-center uppercase tracking-tighter">Paiement sécurisé par cryptage SSL</p>
                </div>
            </div>

        </div>
    </div>

</body>
</html>