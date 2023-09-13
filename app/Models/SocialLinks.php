<?php

namespace App\Models;

class SocialLinks
{
    private ?string $websiteUrl = null;
    private ?string $facebookUrl = null;
    private ?string $instagramUrl = null;
    private ?string $twitterUrl = null;

    public function getWebsiteUrl(): ?string
    {
        return $this->websiteUrl;
    }

    public function setWebsiteUrl(?string $websiteUrl): SocialLinks
    {
        $this->websiteUrl = $websiteUrl;
        return $this;
    }

    public function getFacebookUrl(): ?string
    {
        return $this->facebookUrl;
    }

    public function setFacebookUrl(?string $facebookUrl): SocialLinks
    {
        $this->facebookUrl = $facebookUrl;
        return $this;
    }

    public function getInstagramUrl(): ?string
    {
        return $this->instagramUrl;
    }

    public function setInstagramUrl(?string $instagramUrl): SocialLinks
    {
        $this->instagramUrl = $instagramUrl;
        return $this;
    }

    public function getTwitterUrl(): ?string
    {
        return $this->twitterUrl;
    }

    public function setTwitterUrl(?string $twitterUrl): SocialLinks
    {
        $this->twitterUrl = $twitterUrl;
        return $this;
    }
}
