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
        
        /* On ne scale que sur PC pour ne pas casser le scroll mobile */
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
    <nav id="navbar" class="fixed top-0 w-full z-[100] flex items-center justify-between px-4 md:px-12 py-4 transition-all duration-700 bg-gradient-to-b from-black/90 to-transparent">
        <div class="flex items-center space-x-4 md:space-x-10">
            <h1 class="text-red-600 text-2xl md:text-3xl font-black uppercase tracking-tighter font-serif italic">Cinema</h1>
            <ul class="hidden lg:flex space-x-5 text-sm font-medium">
                <li class="cursor-pointer hover:text-gray-300 transition">Accueil</li>
                <li class="cursor-pointer hover:text-gray-300 transition">Action</li>
                <li class="cursor-pointer hover:text-gray-300 transition font-bold">Drames</li>
                <li class="cursor-pointer hover:text-gray-300 transition">Ma liste</li>
            </ul>
        </div>
        <div class="flex items-center space-x-5">
            <span class="cursor-pointer text-xl">🔍</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs md:text-sm bg-red-600 px-3 py-1 rounded font-bold">Déconnexion</button>
            </form>
        </div>
    </nav>

    <!-- SECTION HERO -->
    @if($heroMovie)
    <header class="relative w-full h-[60vh] sm:h-[70vh] md:h-[85vh] lg:h-[95vh] flex items-end md:items-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ $heroMovie->poster }}" class="w-full h-full object-cover object-top md:object-center opacity-70 md:opacity-90" alt="Hero">
            <div class="absolute inset-0 bg-gradient-to-t from-[#141414] via-[#141414]/40 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/10 to-transparent hidden md:block"></div>
        </div>

        <div class="relative z-20 px-6 md:px-16 pb-12 md:pb-0 w-full md:w-2/3 lg:w-1/2 space-y-3 md:space-y-6">
            <h1 class="text-3xl sm:text-5xl md:text-7xl font-black uppercase leading-none tracking-tighter drop-shadow-2xl italic">
                {{ $heroMovie->name }}
            </h1>
            <p class="hidden sm:block text-sm md:text-lg text-gray-200 line-clamp-2 md:line-clamp-3 font-light max-w-xl drop-shadow-md">
                {{ $heroMovie->description }}
            </p>
            <div class="flex items-center space-x-3 pt-2">
                <button class="flex-1 md:flex-none flex items-center justify-center bg-white text-black px-6 py-2 md:px-10 md:py-3 rounded-sm hover:bg-white/80 font-bold transition text-sm md:text-lg">Ajouter au panier</button>
                <button class="flex-1 md:flex-none flex items-center justify-center bg-gray-500/50 text-white px-6 py-2 md:px-10 md:py-3 rounded-sm hover:bg-gray-500/70 font-bold transition backdrop-blur-md text-sm md:text-lg">Infos</button>
            </div>
        </div>
    </header>
    @endif

    <!-- LISTES DE FILMS -->
    <main class="relative z-30 -mt-12 md:-mt-24 pb-20 space-y-10 md:space-y-16">
        
        @foreach($categories as $category)
        <section class="pl-6 md:pl-16">
            <h2 class="text-lg md:text-2xl font-bold text-gray-100 mb-3 md:mb-5 tracking-wide">
                {{ $category->name }}
            </h2>
            
            <!-- RAIL HORIZONTAL CORRIGÉ -->
            <div class="flex flex-row overflow-x-auto overflow-y-hidden no-scrollbar py-4 space-x-4 pr-10">
                @foreach($category->movies as $movie)
                <div class="movie-card flex-none w-36 sm:w-44 md:w-52 cursor-pointer group relative">
                    
                    <!-- Container Image en mode VERTICAL (Aspect 2/3) -->
                    <div class="relative aspect-[2/3] rounded-md overflow-hidden bg-gray-900 shadow-lg border border-white/5">
                        <img src="{{ $movie->poster }}" class="w-full h-full object-cover transition-all duration-500 md:group-hover:opacity-30" alt="{{ $movie->name }}">
                        
                        <!-- Badge Prix -->
                        <div class="absolute top-2 right-2 bg-black/80 backdrop-blur-md px-2 py-1 rounded text-[10px] md:text-xs font-bold text-green-400 border border-green-400/20 z-30">
                            {{ number_format($movie->price, 2) }} €
                        </div>

                        <!-- Hover Desktop -->
                        <div class="hidden md:flex absolute inset-0 flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-20 p-4">
                            <form action="#" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-sm text-xs font-bold uppercase tracking-tight active:scale-95 transition">
                                    + Panier
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Infos & Bouton Mobile -->
                    <div class="mt-3 flex flex-col space-y-2 px-1">
                        <h3 class="text-[11px] md:text-sm font-semibold text-gray-300 group-hover:text-white transition-colors truncate">
                            {{ $movie->name }}
                        </h3>

                        <!-- Visible sur mobile seulement -->
                        <div class="md:hidden">
                            <form action="#" method="POST">
                                @csrf
                                <input type="hidden" name="movie_id" value="{{ $movie->id }}">
                                <button type="submit" class="w-full bg-white/10 text-white py-2 rounded flex items-center justify-center text-[10px] font-black border border-white/10 active:bg-red-600">
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
        const nav = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                nav.classList.add('bg-[#141414]');
                nav.classList.remove('from-black/90');
            } else {
                nav.classList.remove('bg-[#141414]');
                nav.classList.add('from-black/90');
            }
        });
    </script>
</body>
</html>