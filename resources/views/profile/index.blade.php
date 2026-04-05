<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Cinema</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#141414] text-white font-sans">

    <nav class="p-6 border-b border-white/10 flex justify-between items-center">
        <a href="{{ route('films.index') }}" class="text-red-600 text-2xl font-black uppercase italic">Cinema</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-xs bg-red-600 px-4 py-2 rounded font-bold uppercase hover:bg-red-700">Déconnexion</button>
        </form>
    </nav>

    <div class="max-w-6xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Colonne Gauche : Paramètres -->
            <div class="space-y-8">
                <section class="bg-white/5 p-8 rounded-sm border border-white/10">
                    <h2 class="text-xl font-black uppercase italic mb-6">Sécurité</h2>
                    
                    @if(session('success'))
                        <div class="bg-green-500/20 text-green-400 p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs uppercase text-gray-400 font-bold mb-1">Ancien mot de passe</label>
                            <input type="password" name="current_password" class="w-full bg-black/40 border border-white/10 rounded px-3 py-2 focus:border-red-600 outline-none">
                            @error('current_password') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs uppercase text-gray-400 font-bold mb-1">Nouveau mot de passe</label>
                            <input type="password" name="new_password" class="w-full bg-black/40 border border-white/10 rounded px-3 py-2 focus:border-red-600 outline-none">
                        </div>
                        <div>
                            <label class="block text-xs uppercase text-gray-400 font-bold mb-1">Confirmer le mot de passe</label>
                            <input type="password" name="new_password_confirmation" class="w-full bg-black/40 border border-white/10 rounded px-3 py-2 focus:border-red-600 outline-none">
                        </div>
                        <button type="submit" class="w-full bg-white text-black font-black py-2 uppercase text-xs hover:bg-gray-200 transition">Mettre à jour</button>
                    </form>
                </section>
            </div>

            <!-- Colonne Droite : Ma Vidéothèque -->
            <div class="lg:col-span-2">
                <h2 class="text-3xl font-black uppercase italic mb-8 tracking-tighter">Mes Films Achetés</h2>
                
                @if($purchasedMovies->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($purchasedMovies as $purchase)
                            <div class="group relative overflow-hidden rounded-sm border border-white/5 bg-white/5 transition hover:border-red-600">
                                <img src="{{ $purchase->movie->poster }}" class="w-full aspect-[2/3] object-cover group-hover:scale-105 transition duration-500">
                                <div class="p-3">
                                    <h3 class="text-sm font-bold truncate uppercase tracking-tight">{{ $purchase->movie->name }}</h3>
                                    <button class="mt-2 w-full bg-red-600/20 text-red-500 text-[10px] font-black py-2 uppercase tracking-widest border border-red-600/30">Visionner</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="py-20 text-center border border-dashed border-white/10 rounded">
                        <p class="text-gray-500 italic">Vous n'avez pas encore de films dans votre collection.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

</body>
</html>