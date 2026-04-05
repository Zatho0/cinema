<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->name }} - Infos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#141414] text-white font-sans antialiased">

    <!-- NAVBAR  -->
    <nav id="navbar" class="fixed top-0 w-full z-[100] transition-all duration-700 bg-[#141414] md:bg-gradient-to-b md:from-black/90 md:to-transparent">
        <div class="px-4 md:px-12 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4 md:space-x-10">
                <button id="mobile-menu-button" class="lg:hidden text-white text-2xl focus:outline-none">☰</button>
                <h1 class="text-red-600 text-2xl md:text-3xl font-black uppercase tracking-tighter font-serif italic cursor-pointer">
                    <a href="{{ route('films.index') }}">Cinema</a>
                </h1>
                <ul class="hidden lg:flex space-x-5 text-sm font-medium">
                    <li><a href="{{ route('films.index') }}" class="hover:text-red-600 transition {{ request()->routeIs('films.index') ? 'text-red-600 font-bold' : '' }}">Accueil</a></li>
                    <li><a href="{{ route('films.categories', ['slug' => 'Action']) }}" class="hover:text-red-600 transition {{ request()->is('category/Action') ? 'text-red-600 font-bold' : '' }}">Action</a></li>
                    <li><a href="{{ route('films.categories', ['slug' => 'Drame']) }}" class="hover:text-red-600 transition {{ request()->is('category/Drame') ? 'text-red-600 font-bold' : '' }}">Drames</a></li>
                </ul>
            </div>
            <!-- Droite : Recherche + Panier + Profil -->
            <div class="flex items-center space-x-5">
                
                <!-- Barre de Recherche (Desktop) -->
                <form action="{{ route('films.index') }}" method="GET" class="relative hidden sm:block">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." 
                        class="bg-black/40 border border-gray-600 text-white text-xs rounded-full px-4 py-1.5 focus:outline-none focus:border-red-600 w-40 md:w-60 transition-all">
                </form>

                <!-- BOUTON PANIER -->
                <a href="{{ route('cart.index') }}" class="relative group p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 group-hover:text-red-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <!-- Badge Notification (Compteur dynamique) -->
                    <span class="absolute -top-1 -right-1 bg-red-600 text-[10px] font-bold px-1.5 rounded-full border-2 border-[#141414]">
                        {{ Auth::user()->cartItems->count() }}
                    </span>
                </a>

                <!-- MENU PROFIL  -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-2 focus:outline-none">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=E50914&color=fff" 
                            class="w-8 h-8 rounded-sm object-cover border border-gray-700" alt="Avatar">
                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        class="absolute right-0 mt-3 w-48 bg-[#141414] border border-white/10 rounded-sm shadow-2xl py-2 z-[110]">
                        
                        <div class="px-4 py-2 border-b border-white/5 mb-2">
                            <p class="text-xs text-gray-400 italic">Connecté en tant que</p>
                            <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                        </div>

                        <a href="#" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white transition">Compte</a>
                        <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white transition">Mon Panier</a>
                        
                        <div class="border-t border-white/5 mt-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-600/10 font-bold transition">
                                    Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- BANNIÈRE INFOS -->
    <div class="relative w-full h-[70vh] md:h-[85vh] flex items-center">
        <!-- Image de fond -->
        <div class="absolute inset-0">
            <img src="{{ $movie->poster }}" class="w-full h-full object-cover opacity-40 blur-sm" alt="">
            <div class="absolute inset-0 bg-gradient-to-t from-[#141414] via-[#141414]/60 to-transparent"></div>
        </div>

        <div class="relative z-20 container mx-auto px-6 md:px-12 flex flex-col md:flex-row items-center md:items-start gap-10">
            <!-- Affiche du film -->
            <div class="w-64 md:w-80 flex-none shadow-2xl rounded-lg overflow-hidden border border-white/10">
                <img src="{{ $movie->poster }}" class="w-full h-full object-cover" alt="{{ $movie->name }}">
            </div>

            <!-- Détails -->
            <div class="flex-1 space-y-6 text-center md:text-left">
                <h1 class="text-4xl md:text-6xl font-black uppercase tracking-tighter italic">{{ $movie->name }}</h1>
                
                <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm font-bold">
                    <span class="text-green-400">{{ number_format($movie->price, 2) }} €</span>
                    <span class="border border-gray-500 px-2 py-0.5 text-xs text-gray-400">HD</span>
                    <span class="text-gray-300">2024</span>
                </div>

                <p class="text-gray-300 text-lg leading-relaxed max-w-2xl">
                    {{ $movie->description }}
                </p>

                <div class="space-y-2">
                    <p class="text-gray-400">
                        <span class="text-gray-500 font-bold uppercase text-xs tracking-widest">Réalisateur :</span> 
                        <a href="{{ route('films.director', $movie->director) }}" class="text-white hover:text-red-600 underline decoration-red-600 underline-offset-4 transition">
                            {{ $movie->director }}
                        </a>
                    </p>
                    <p class="text-gray-400">
                        <span class="text-gray-500 font-bold uppercase text-xs tracking-widest">Acteurs :</span> 
                        <span class="text-white">Robert Downey Jr., Scarlett Johansson, Chris Evans</span>
                    </p>
                </div>

                <div class="pt-6">
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                        <button class="bg-red-600 hover:bg-red-700 text-white px-12 py-4 rounded-md font-black uppercase tracking-widest shadow-lg transform active:scale-95 transition-all w-full md:w-auto">
                            + Ajouter au panier
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    
     <script>
        // Gestion du menu hamburger
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });

        // Gestion de la couleur de la navbar au scroll
        const nav = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('bg-[#141414]');
                nav.classList.remove('md:bg-gradient-to-b');
            } else {
                if (window.innerWidth > 1024) { // Uniquement sur PC
                    nav.classList.remove('bg-[#141414]');
                    nav.classList.add('md:bg-gradient-to-b');
                }
            }
        });
    </script>
</body>

</html>