<div class="w-2/3 bg-white rounded-md shadow-md p-6">
    <div class="pb-8">
        <div class="mb-2 flex items-center">
            <div>
                <h2 class="font-bold text-xl">#{{ $issue->internal_id }} {{ $issue->title }}</h2>
            </div>
            <div class="material-symbols-outlined ml-2 hover:text-purple-700">
                <a href="{{ route('time-entries.create', ['issue_id' => $issue->id]) }}" target="_blank">play_circle</a>
            </div>
        </div>
        <div class="flex items-center">
            <div class="badge badge-primary text-white rounded-xl">{{ $issue->state }}</div>
            <div class="ml-4">Issue created {{ $issue->created_at->diffForHumans() }} by Amitav Roy</div>
        </div>
    </div>

    <div class="issue-content">
        <x-markdown>{{ $issue->description }}</x-markdown>
    </div>
</div>
