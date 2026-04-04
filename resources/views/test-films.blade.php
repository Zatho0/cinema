<!DOCTYPE html>
<html>
<head>
    <title>Test Database</title>
    <style>
        body { font-family: sans-serif; background: #1a1a1a; color: white; padding: 50px; }
        h1 { color: #e50914; }
        .film-item { border-bottom: 1px solid #333; padding: 10px 0; }
        .director { color: #aaa; font-style: italic; }
    </style>
</head>
<body>

    <h1>Ma Liste de Films (Import TMDB)</h1>

    @if($movies->isEmpty())
        <p>La base est vide... As-tu bien lancé le Seeder ?</p>
    @else
        <ul>
            @foreach($movies as $movie)
                <li class="film-item">
                    <strong>{{ $movie->name }}</strong> 
                    <span class="director"> - Réalisé par : {{ $movie->director }}</span>
                    <img src="{{$movie -> poster }}" alt="" srcset="">
                    <br>
                    <small>Prix : {{ $movie->price }}€ | Catégorie ID : {{ $movie->categories_id }}</small>
                </li>
            @endforeach
        </ul>
    @endif

</body>
</html>