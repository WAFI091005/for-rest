<button wire:click="toggleLike" class="flex items-center text-sm text-green-600 hover:text-green-800">
    @if ($isLiked)
        ❤️
    @else
        🤍
    @endif
    <span class="ml-1">{{ $likesCount }}</span>
</button>
