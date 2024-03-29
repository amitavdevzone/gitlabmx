@php use App\Services\TimeEntryService; @endphp
<div class="flex justify-end" wire:poll.1s="updateToggle">
    @if($started)
        <div class="mr-4">{{ $entry?->description }}</div>
        <div class="mr-4">{{ $elapsedTime }}</div>
    @endif
    <div class="hover:cursor-pointer">
        @if($started)
            <span  wire:click="$dispatch('toggle-tracking', { id: {{ $id }} })"
                   class="material-symbols-outlined ml-2 hover:text-purple-700">pause_circle</span>
        @else
            <span  wire:click="$dispatch('toggle-tracking', { id: {{ $id }} })"
                   class="material-symbols-outlined ml-2 hover:text-purple-700">play_circle</span>
        @endif
    </div>
</div>
