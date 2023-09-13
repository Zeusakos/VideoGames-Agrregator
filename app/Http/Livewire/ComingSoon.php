<?php

namespace App\Http\Livewire;

use App\Services\Integrations\IGDBService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Livewire\Component;

class ComingSoon extends Component
{
    public $comingSoon = [];
    private IGDBService $IGDBService;

    public function boot(IGDBService $IGDBService)
    {
        $this->IGDBService = $IGDBService;
    }
    public function loadComingSoon()
    {
        $this->comingSoon = $this->IGDBService->getComingSoonGames();
    }

    public function render()
    {
        return view('livewire.coming-soon');
    }

    private function formatForView($games)
    {
        return collect($games)->map(function ($game) {
            return collect($game)->merge([
                'coverImageUrl' => isset($game['cover']) && isset($game['cover']['url']) ? Str::replaceFirst('thumb', 'cover_small', $game['cover']['url']) : null,
                'releaseDate' => Carbon::parse($game['first_release_date'])->format('M d, Y'),
            ]);
        })->toArray();
    }
}
