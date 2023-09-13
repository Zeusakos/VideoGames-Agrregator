<?php

namespace App\Models;

use DateTime;

class Game extends BaseGame
{
    private DateTime $firstReleaseDate;
    private ?int $criticsRating;
    private ?string $summary;
    private ?string $company;
    /** @var string[] */
    private array $genres = [];
    private ?string $trailerUrl;
    /** @var string[] */
    private array $screenshots = [];
    /** @var BaseGame[]  */
    private array $similarGames = [];
    private ?SocialLinks $socialLinks = null;

    public function getFirstReleaseDate(): DateTime
    {
        return $this->firstReleaseDate;
    }

    public function setFirstReleaseDate(DateTime $firstReleaseDate): Game
    {
        $this->firstReleaseDate = $firstReleaseDate;
        return $this;
    }

    public function getCriticsRating(): ?int
    {
        return $this->criticsRating;
    }

    public function setCriticsRating(?int $criticsRating): Game
    {
        $this->criticsRating = $criticsRating;
        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): Game
    {
        $this->summary = $summary;
        return $this;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setCompany(?string $company): Game
    {
        $this->company = $company;
        return $this;
    }

    public function getGenres(): array
    {
        return $this->genres;
    }

    public function setGenres(array $genres): Game
    {
        $this->genres = $genres;
        return $this;
    }

    public function getTrailerUrl(): ?string
    {
        return $this->trailerUrl;
    }

    public function setTrailerUrl(?string $trailerUrl): Game
    {
        $this->trailerUrl = $trailerUrl;
        return $this;
    }

    public function getScreenshots(): array
    {
        return $this->screenshots;
    }

    public function setScreenshots(array $screenshots): Game
    {
        $this->screenshots = $screenshots;
        return $this;
    }

    public function getSimilarGames(): array
    {
        return $this->similarGames;
    }

    public function setSimilarGames(array $similarGames): Game
    {
        $this->similarGames = $similarGames;
        return $this;
    }

    public function getSocialLinks(): ?SocialLinks
    {
        return $this->socialLinks;
    }

    public function setSocialLinks(?SocialLinks $socialLinks): Game
    {
        $this->socialLinks = $socialLinks;
        return $this;
    }
}
