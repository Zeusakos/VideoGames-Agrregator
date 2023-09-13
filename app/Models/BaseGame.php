<?php

namespace App\Models;

class BaseGame
{
    protected string $name;
    protected string $slug;
    protected ?string $coverUrl;
    protected ?int $memberRating;
    /** @var string[] */
    protected array $platforms = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): BaseGame
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): BaseGame
    {
        $this->slug = $slug;
        return $this;
    }

    public function getCoverUrl(): ?string
    {
        return $this->coverUrl;
    }

    public function setCoverUrl(?string $coverUrl): BaseGame
    {
        $this->coverUrl = $coverUrl;
        return $this;
    }

    public function getMemberRating(): ?int
    {
        return $this->memberRating;
    }

    public function setMemberRating(?int $memberRating): BaseGame
    {
        $this->memberRating = $memberRating;
        return $this;
    }

    public function getPlatforms(): array
    {
        return $this->platforms;
    }

    public function setPlatforms(array $platforms): BaseGame
    {
        $this->platforms = $platforms;
        return $this;
    }
}
