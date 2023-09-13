@php
/** @var \App\Models\Game $game */
@endphp
<div class="game flex">
    <a href="#"><img src="{{$game->getCoverUrl()}}" alt="game cover" class="w-16 hover:opacity-75 transition ease-in-out duration-150"></a>
    <div class="ml-4">
        <a href="#" class="hover:text-gray-300">{{ $game->getName() }}</a>
        <div class="text-gray-400 text-sm mt-1">{{ \Carbon\Carbon::parse($game->getFirstReleaseDate())->toDateString() }}</div>
    </div>
</div>
