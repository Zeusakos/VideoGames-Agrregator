<?php

namespace App\Http\Livewire;

use App\Services\Integrations\IGDBService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class MostAnticipated extends Component
{
    public $mostAnticipated = [];

    private IGDBService $IGDBService;

    public function boot(IGDBService $IGDBService)
    {
        $this->IGDBService = $IGDBService;
    }
    public function loadMostAnticipated()
    {
        $current = Carbon::now()->timestamp;
        $afterFourMonths=Carbon::now()->addMonths(4)->timestamp;

        $mostAnticipatedUnformatted = Http::withHeaders(config('services.igdb'))->withBody("
        fields name,cover.url,first_release_date,total_rating_count,platforms.abbreviation,rating,slug;
        where platforms = (48,49,130,6)
        &(first_release_date >= {$current}
        & first_release_date < {$afterFourMonths}
        );
        limit 4;
        " ,"text/plain")->post('https://api.igdb.com/v4/games')
            ->json();

        $this->mostAnticipated= $this->IGDBService->getMostAnticipatedGames();
    }

    public function render()
    {
        return view('livewire.most-anticipated');
    }

    private function formatForView($games)
    {
        return collect($games)->map(function ($game)
        {
            return collect($game)->merge([
                'coverImageUrl'=>isset($game['cover']) && isset($game['cover']['url']) ? Str::replaceFirst('thumb','cover_small', $game['cover']['url']) : null,
                'releaseDate' => Carbon::parse($game['first_release_date'])->format('M d, Y'),
            ]);
        })->toArray();
    }

}
