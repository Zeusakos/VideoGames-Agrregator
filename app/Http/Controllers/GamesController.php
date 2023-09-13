<?php

namespace App\Http\Controllers;

use App\Services\Integrations\IGDBService;
use Illuminate\View\View;

class GamesController extends Controller
{
    public function __construct(
        private readonly IGDBService $IGDBService,
    )
    {
    }

    public function index(): View
    {
        return view('index');
    }

    public function show(string $slug): View
    {
        $game = $this->IGDBService->getGameBySlug($slug);

        abort_if(!$game, 404);

        return view('show', [
            'game' => $game
        ]);
    }
}
