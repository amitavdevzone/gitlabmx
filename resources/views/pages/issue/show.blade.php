@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Issue
    </div>
    <div>
        <livewire:time-tracker />
    </div>
@endsection

@section('breadcrumb')
    @php
        $crumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Project', 'url' => route('projects.show', ['project' => $project])],
            ['name' => 'Issue', 'url' => route('issues.index', ['project' => $project])],
            ['name' => $issue->title],
        ];
    @endphp
    @include('components.breadcrumb', $crumbs)
@endsection

@section('content')
    <livewire:gitlab-issue-view :project="$project" :issue="$issue" />

    <div class="w-2/3 px-8 pt-8 mt-4">
        @if($comments->count() > 0)
            <h2 class="text-xl">Comments</h2>
        @endif
        @foreach($comments as $comment)
            <div class="rounded border border-gray-200 p-6 mt-2 flex flex-col bg-white">
                <div class="pb-2">
                    <span class="font-bold">{{ $comment?->author?->name }}</span>
                    <span class="opacity-50 text-sm">{{ $comment->updated_at->diffForHumans() }}</span>
                </div>
                <div>{{ $comment->body }}</div>
            </div>
        @endforeach
    </div>
@endsection
