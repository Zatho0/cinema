<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Category;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $apiKey = 'c9f48675a5ac97272fd7cb5f07f170ca';
        
        $categoryAction = Category::firstOrCreate(
            ['name' => 'Action'],
            ['slug' => 'action']
        );
        $categoryDrame = Category::firstOrCreate(
            ['name' => 'Drame'],
            ['slug' => 'drame']
        );
        $category = [$categoryAction-> id, $categoryDrame->id];

        // Boucle pour récupérer 5 pages de résultats (20 films par page)
        for ($page = 1; $page <= 5; $page++) {
            
            $response = Http::get("https://api.themoviedb.org/3/discover/movie", [
                'api_key'        => $apiKey,
                'with_companies' => '420', // Marvel Studios
                'language'       => 'fr-FR',
                'page'           => $page, // On change de page à chaque tour
            ]);

            if ($response->successful()) {
                $moviesList = $response->json()['results'];

                foreach ($moviesList as $data) {
                    $randomCategoryId = $category[array_rand($category)];
                    // On cherche le réalisateur
                    $director = $this->getDirector($data['id'], $apiKey);

                    Movie::updateOrCreate(
                        ['name' => $data['title']],
                        [
                            'description' => $data['overview'] ?? 'Pas de synopsis.',
                            'poster'       => 'https://image.tmdb.org/t/p/w500' . $data['poster_path'],
                            'price'       => rand(14, 29) . '.99',
                            'categories_id' => $randomCategoryId,
                            'director'    => $director,
                        ]
                    );
                }
            }
            
           
            usleep(200000); // 0.2 secondes
        }
    }

    
    private function getDirector($movieId, $apiKey)
    {
        $credits = Http::get("https://api.themoviedb.org/3/movie/{$movieId}/credits", [
            'api_key' => $apiKey
        ]);

        if ($credits->successful()) {
            foreach ($credits->json()['crew'] as $member) {
                if ($member['job'] === 'Director') {
                    return $member['name'];
                }
            }
        }
        return 'Inconnu';
    }
}