<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinema Marvel - Stream</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        body { background-color: #141414; margin: 0; overflow-x: hidden; }

        .movie-card {
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        
        @media (min-width: 768px) {
            .movie-card:hover {
                transform: scale(1.1);
                z-index: 50;
            }
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="text-white font-sans antialiased bg-[#141414]">

    <!-- NAVBAR -->
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
                    <!-- Badge Notification (Optionnel : Compteur dynamique) -->
                    <span class="absolute -top-1 -right-1 bg-red-600 text-[10px] font-bold px-1.5 rounded-full border-2 border-[#141414]">
                        {{ Auth::user()->cartItems->count() }}
                    </span>
                </a>

                <!-- MENU PROFIL (Alpine.js) -->
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

                        <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-300 hover:bg-white/5 hover:text-white transition">Compte</a>
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

    <!-- SECTION HERO -->
    @if($heroMovie)
    <header class="relative w-full h-[60vh] sm:h-[70vh] md:h-[85vh] lg:h-[95vh] flex items-end md:items-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ $heroMovie->poster }}" class="w-full h-full object-cover object-top md:object-center opacity-70 md:opacity-90" alt="Hero">
            <div class="absolute inset-0 bg-gradient-to-t from-[#141414] via-[#141414]/40 to-transparent"></div>
        </div>
        <div class="relative z-20 px-6 md:px-16 pb-12 md:pb-0 w-full md:w-2/3 lg:w-1/2 space-y-3 md:space-y-6">
            <h1 class="text-3xl sm:text-5xl md:text-7xl font-black uppercase leading-none tracking-tighter italic">{{ $heroMovie->name }}</h1>
            <p class="hidden sm:block text-sm md:text-lg text-gray-200 line-clamp-3 font-light max-w-xl">{{ $heroMovie->description }}</p>
            <div class="flex items-center space-x-3 pt-2">
                 
                <a href="{{ route('films.show', $heroMovie->id) }}" class="flex-1 md:flex-none bg-gray-500/50 text-white px-6 py-2 md:px-10 md:py-3 rounded-sm hover:bg-gray-500/70 font-bold transition text-center backdrop-blur-md">
                    Infos
                </a>
            </div>
        </div>
    </header>
    @endif

    <!-- LISTES DE FILMS -->
    <main class="relative z-30 {{ request('search') || request()->routeIs('films.categories') ? 'pt-28 md:pt-40' : '-mt-12 md:-mt-24' }} pb-20 space-y-10 md:space-y-16">
        @foreach($categories as $category)
        <section class="pl-6 md:pl-16">
            <h2 class="text-lg md:text-2xl font-bold text-gray-100 mb-3 md:mb-5 tracking-wide">{{ $category->name }}</h2>
            
            <div class="flex flex-row overflow-x-auto overflow-y-hidden no-scrollbar py-4 space-x-4 pr-10">
                @foreach($category->movies as $movie)
                <div class="movie-card flex-none w-36 sm:w-44 md:w-52 group relative">
                    
                    <!-- L'image est enveloppée dans le lien -->
                    <div class="relative aspect-[2/3] rounded-md overflow-hidden bg-gray-900 shadow-lg border border-white/5">
                        <a href="{{ route('films.show', $movie->id) }}" class="block w-full h-full">
                            <img src="{{ $movie->poster }}" class="w-full h-full object-cover transition-all duration-500 md:group-hover:opacity-30" alt="{{ $movie->name }}">
                        </a>

                        <!-- Badge Prix (pointer-events-none pour ne pas gêner le clic sur l'image) -->
                        <div class="absolute top-2 right-2 bg-black/80 backdrop-blur-md px-2 py-1 rounded text-[10px] md:text-xs font-bold text-green-400 z-20 pointer-events-none">
                            {{ number_format($movie->price, 2) }} €
                        </div>

                        <!-- Hover Desktop : Bouton Panier (Z-index plus élevé pour être cliquable) -->
                        <div class="hidden md:flex absolute inset-0 flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-30 p-4 pointer-events-none">
                            <form action="{{ route('cart.add') }}" method="POST" class="w-full pointer-events-auto">
                                @csrf
                                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-sm text-xs font-bold uppercase active:scale-95 transition">
                                    + Panier
                                </button>
                            </form>
                            <a href="{{ route('films.show', $movie->id) }}" class="mt-3 text-[10px] text-gray-300 underline uppercase tracking-widest pointer-events-auto">Détails</a>
                        </div>
                    </div>

                    <!-- Titre cliquable aussi -->
                    <div class="mt-3 px-1">
                        <a href="{{ route('films.show', $movie->id) }}" class="block">
                            <h3 class="text-[11px] md:text-sm font-semibold text-gray-300 group-hover:text-white transition-colors truncate">
                                {{ $movie->name }}
                            </h3>
                        </a>
                        
                        <!-- Bouton Panier Mobile -->
                        <div class="md:hidden mt-2">
                            <form action="#" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-white/10 text-white py-1.5 rounded text-[10px] font-black border border-white/10">
                                    + Panier
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endforeach
    </main>

    <footer class="text-center py-10 border-t border-gray-800 text-gray-600 text-xs uppercase tracking-widest">
        &copy; 2026 Cinema Marvel Clone
    </footer>

    <script>
        const btn = document.getElementById('mobile-menu-button');
        const menu = document.getElementById('mobile-menu');
        if(btn) btn.addEventListener('click', () => menu.classList.toggle('hidden'));

        const nav = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('bg-[#141414]');
                nav.classList.remove('md:bg-gradient-to-b');
            } else {
                nav.classList.remove('bg-[#141414]');
                nav.classList.add('md:bg-gradient-to-b');
            }
        });
    </script>
</body>
</html>