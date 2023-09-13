<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Services\Integrations\IGDBService;
use Livewire\Component;

class RecentlyReviewed extends Component
{
    public array $recentlyReviewed = [];

    private IGDBService $IGDBService;

    public function boot(IGDBService $IGDBService)
    {
        $this->IGDBService = $IGDBService;
    }

    public function loadRecentlyReviewed()
    {
        $this->recentlyReviewed = $this->IGDBService->getRecentlyReviewed();

        collect($this->recentlyReviewed)->filter(function (Game $game) {
            return $game->getMemberRating();
        })->each(function (Game $game) {
            $this->emit('reviewGameWithRatingAdded', [
                'slug' => 'review_' . $game->getSlug(),
                'rating' => $game->getMemberRating() / 100
            ]);
        });
    }

    public function render()
    {
        return view('livewire.recently-reviewed');
    }
}
