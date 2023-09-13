@php
    /** @var App\Models\Game $game */
@endphp
<div class="game mt-8">
    <div class="relative inline-block">
        <a href="{{ route('games.show', $game->getSlug()) }}">
            <img src="{{ $game->getCoverUrl() }}" alt="game cover" class="hover:opacity-75 transition ease-in-out duration-150">
        </a>
        @if ($game->getMemberRating())
            <div id="{{$game->getSlug()}}" class="absolute bottom-0 right-0 w-16 h-16 bg-gray-800 rounded-full" style="right: -20px; bottom: -20px">
                @push('scripts')
                    @include('_rating',[
                        'slug' => $game->getSlug(),
                        'rating' => $game->getMemberRating(),
                        'event' =>null
                        ])
                @endpush
            </div>
        @endif
    </div>
    <a href="{{ route('games.show', $game->getSlug()) }}" class="block text-base font-semibold leading-tight hover:text-gray-400 mt-8">{{ $game->getName() }}</a>
    <div class="text-gray-400 mt-1">
        {{ implode(',', $game->getPlatforms()) }}
    </div>
</div>


