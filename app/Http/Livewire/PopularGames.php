<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Services\Integrations\IGDBService;
use Livewire\Component;

class PopularGames extends Component
{
    public $popularGames = [];
    private IGDBService $IGDBService;

    public function boot(IGDBService $IGDBService)
    {
        $this->IGDBService = $IGDBService;
    }

    public function loadPopularGames()
    {
        $this->popularGames = $this->IGDBService->getPopularGames();

        collect($this->popularGames)
            ->filter(function (Game $game) {
                return $game->getMemberRating() > 0;
            })->values()->each(function (Game $game) {
                $this->emit('gameWithRatingAdded', [
                    'slug' => $game->getSlug(),
                    'rating' => $game->getMemberRating() / 100
                ]);
            });
    }


    public function render()
    {
        return view('livewire.popular-games');
    }
}
