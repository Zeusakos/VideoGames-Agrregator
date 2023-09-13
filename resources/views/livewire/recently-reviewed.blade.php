@php
/** @var \App\Models\Game[] $recentlyReviewed */
@endphp
<div wire:init='loadRecentlyReviewed' class="recently-reviewed-container space-y-12 mt-8">
    @forelse ($recentlyReviewed as $game)
        <div class="game bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
            <div class="relative flex-none">
                    <a href="#">
                        <img src="{{$game->getCoverUrl()}}" alt="game cover"
                             class="w-48 hover:opacity-75 transition ease-in-out duration-150">
                    </a>
                <div id="review_{{$game->getSlug()}}" class="absolute bottom-0 right-0 w-16 h-16 bg-gray-900 rounded-full text-xs"
                     style="right: -20px; bottom: -20px">
                </div>
            </div>
            <div class="ml-6 lg:ml-12">
                <a href="#"
                   class="block text-lg font-semibold leading-tight hover:text-gray-400 mt-4">{{ $game->getName() }}</a>
                <div class="text-gray-400 mt-1">
                    {{ implode(',', $game->getPlatforms()) }}
                </div>
                <p class="mt-6 text-gray-400 hidden lg:block">
                    {{ $game->getSummary() }}
                </p>
            </div>
        </div> <!-- end game -->
    @empty
        @foreach(range(1, 3) as $iteration)
        <div class="game bg-gray-800 rounded-lg shadow-md flex px-6 py-6">
            <div class="relative flex-none">
                <div class="bg-gray-700 w-32 lg:w-48 h-40 lg:h-56"></div>
            </div>
            <div class="ml-6 lg:ml-12">
                <a href="#" class=" inline-block text-lg font-semibold leading-tight text-transparent bg-gray-700 rounded hover:text-gray-400 mt-4">title goes here</a>
                <div class="mt-8 space-y-4 hidden lg:block">
                    <span class='text-transparent bg-gray-700 rounded inline-block'>Please note that this code Please note that this code </span>
                    <span class='text-transparent bg-gray-700 rounded inline-block'>Please note that this code Please note that this code </span>
                    <span class='text-transparent bg-gray-700 rounded inline-block'>Please note that this code Please note that this code </span>


                </div>
            </div>
        </div> <!-- end game -->
        @endforeach
    @endforelse
</div>

@push('scripts')
    @include('_rating',[
    'event'=>'reviewGameWithRatingAdded'
])
@endpush
