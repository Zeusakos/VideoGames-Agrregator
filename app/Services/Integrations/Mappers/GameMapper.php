<?php

namespace App\Services\Integrations\Mappers;

use App\Models\BaseGame;
use App\Models\Game;
use App\Models\SocialLinks;
use Carbon\Carbon;
use Illuminate\Support\Str;

class GameMapper
{
    public function mapToGame(object $rawGame): Game
    {
        $baseGame = $this->mapToBaseGame($rawGame);
        $trailerUrl = isset($rawGame->videos) && count($rawGame->videos) >= 1
            ? 'https://youtube.com/embed/' . $rawGame->videos[0]->video_id : null;
        $genres = isset($rawGame->genres)
            ? collect($rawGame->genres)->pluck('name')->toArray()
            : [];

        return (new Game())
            ->setName($baseGame->getName())
            ->setSlug($baseGame->getSlug())
            ->setCoverUrl($baseGame->getCoverUrl())
            ->setFirstReleaseDate(Carbon::parse($rawGame->first_release_date)->toDate())
            ->setMemberRating($baseGame->getMemberRating())
            ->setCriticsRating(isset($rawGame->aggregated_rating) ? round($rawGame->aggregated_rating) : 0)
            ->setPlatforms($baseGame->getPlatforms())
            ->setSummary($rawGame->summary ?? null)
            ->setTrailerUrl($trailerUrl)
            ->setGenres($genres)
            ->setCompany($rawGame->involved_companies[0]->company->name ?? null)
            ->setScreenshots($this->mapScreenshots($rawGame->screenshots ?? [], 9))
            ->setSimilarGames($this->mapSimilarGames($rawGame->similar_games ?? [], 6))
            ->setSocialLinks($this->mapSocialLinks($rawGame->websites ?? []));
    }

    public function mapToBaseGame(object $rawGame): BaseGame
    {
        $coverUrl = isset($rawGame->cover->url)
            ? Str::replaceFirst('thumb', 'cover_big', $rawGame->cover->url)
            : "https://placehold.co/264x352?text=Game%20Cover";
        $platforms = collect($rawGame->platforms)->pluck('abbreviation')->toArray();

        return (new BaseGame())
            ->setName((string)$rawGame->name)
            ->setSlug((string)$rawGame->slug)
            ->setCoverUrl($coverUrl)
            ->setMemberRating(isset($rawGame->rating) ? round($rawGame->rating) : 0)
            ->setPlatforms($platforms);
    }

    /**
     * @param object[] $similarGames
     * @return BaseGame[]
     */
    private function mapSimilarGames(?array $similarGames, $limit): array
    {
        return isset($similarGames)
            ? collect($similarGames)
                ->take($limit)
                ->map(fn($similarGame) => $this->mapToBaseGame($similarGame))
                ->toArray()
            : [];
    }

    private function mapScreenshots(?array $screenshots, int $limit): array
    {
        return isset($screenshots)
            ? collect($screenshots)
                ->take($limit)
                ->map(fn($screenshot) => Str::replaceFirst('thumb', 'screenshot_big', $screenshot->url))
                ->toArray()
            : [];
    }

    private function mapSocialLinks(?array $socialLinks): ?SocialLinks
    {
        if (isset($socialLinks) && count($socialLinks) >= 1) {
            $socialLinksCollection = collect($socialLinks);

            return (new SocialLinks())
                ->setWebsiteUrl($socialLinksCollection->first()->url)
                ->setFacebookUrl(
                    $socialLinksCollection->filter(fn($link) => Str::contains($link->url, "facebook"))
                        ->first()
                        ?->url
                )
                ->setTwitterUrl($socialLinksCollection->filter(fn($link) => Str::contains($link->url, "twitter"))
                    ->first()
                    ?->url
                )
                ->setInstagramUrl($socialLinksCollection->filter(fn($link) => Str::contains($link->url, "instagram"))
                    ->first()
                    ?->url
                );
        }

        return null;
    }
}
