<?php

namespace App\Services\Integrations;

use App\Models\Game;
use App\Services\Integrations\Mappers\GameMapper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class IGDBService
{
    private const BASE_URL = "https://api.igdb.com/v4/";

    public function __construct(private readonly GameMapper $gameMapper)
    {

    }

    public function getGameBySlug(string $slug): ?Game
    {
        $gameObject = Http::withHeaders(config('services.igdb'))->withBody("
    fields name,cover.url,first_release_date,platforms.abbreviation,rating,slug,involved_companies.company.name,
    genres.name,aggregated_rating,summary,websites.*,videos.*,screenshots.*,similar_games.name,similar_games.cover.url,similar_games.rating,
    similar_games.platforms.abbreviation,similar_games.slug;
    where slug=\"{$slug}\";", "text/plain")
            ->post(self::BASE_URL . 'games')
            ->object();

        return isset($gameObject)
            ? $this->gameMapper->mapToGame($gameObject[0])
            : null;
    }

    public function getPopularGames(): array
    {
        $before = Carbon::now()->subYears(2)->timestamp;
        $after = Carbon::now()->addYears(2)->timestamp;

        $gameObjects = Http::withHeaders(config('services.igdb'))->withBody("
        fields name,cover.url,first_release_date,total_rating_count,platforms.abbreviation,rating,slug;
        where rating > 90
        &(first_release_date >= {$before}
        & first_release_date < {$after}
        );
        limit 12;", "text/plain")
            ->post(self::BASE_URL . 'games')
            ->object();

        return isset($gameObjects)
            ? collect($gameObjects)->map(fn($rawGame) => $this->gameMapper->mapToGame($rawGame))->toArray()
            : [];
    }

    public function getComingSoonGames(): array
    {
        $current = Carbon::now()->timestamp;

        $gameObjects = Http::withHeaders(config('services.igdb'))->withBody("
        fields name,cover.url,first_release_date,total_rating_count,platforms.abbreviation,rating,slug;
        where platforms = (48,49,130,6)
        &(first_release_date >= {$current}
        );
        sort first_release_date asc;
        limit 4;
        ", "text/plain")
            ->post(self::BASE_URL . 'games')
            ->object();

        return isset($gameObjects)
            ? collect($gameObjects)->map(fn($rawGame) => $this->gameMapper->mapToGame($rawGame))->toArray()
            : [];
    }

    public function getMostAnticipatedGames(): array
    {
        $current = Carbon::now()->timestamp;
        $afterFourMonths = Carbon::now()->addMonths(4)->timestamp;

        $gameObjects = Http::withHeaders(config('services.igdb'))->withBody("
        fields name,cover.url,first_release_date,total_rating_count,platforms.abbreviation,rating,slug;
        where platforms = (48,49,130,6)
        &(first_release_date >= {$current}
        & first_release_date < {$afterFourMonths}
        );
        limit 4;", "text/plain")
            ->post(self::BASE_URL . 'games')
            ->object();

        return isset($gameObjects)
            ? collect($gameObjects)->map(fn($rawGame) => $this->gameMapper->mapToGame($rawGame))->toArray()
            : [];
    }

    public function getRecentlyReviewed(): array
    {
        $before = Carbon::now()->subYears(2)->timestamp;
        $current = Carbon::now()->timestamp;

        $gameObjects = Http::withHeaders(config('services.igdb'))->withBody("
        fields name,cover.url,first_release_date,total_rating_count,platforms.abbreviation,rating,slug,summary;
        where rating > 90
        &(first_release_date >= {$before}
        & first_release_date < {$current}
        & rating_count > 5);
        limit 3;" ,"text/plain")
            ->post(self::BASE_URL . 'games')
            ->object();

        return isset($gameObjects)
            ? collect($gameObjects)->map(fn($rawGame) => $this->gameMapper->mapToGame($rawGame))->toArray()
            : [];
    }
}
