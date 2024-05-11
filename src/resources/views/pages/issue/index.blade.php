@php use App\Services\UtilService; @endphp
@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Issue list
    </div>
@endsection

@section('breadcrumb')
    @php
        $crumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Project', 'url' => route('projects.show', ['project' => $project])],
            ['name' => $project->name],
        ];
    @endphp
    @include('components.breadcrumb', $crumbs)
@endsection

@section('content')
    <div class="w-1/4">
        <div role="tablist" class="tabs tabs-bordered">
            <a role="tab"
               class="tab {{ $state == 'opened' ? 'tab-active' : '' }}"
               href="{{ route('issues.index', ['project' => $project, 'state' => 'opened']) }}">
                Opened
            </a>
            <a role="tab"
               class="tab {{ $state == 'closed' ? 'tab-active' : '' }}"
               href="{{ route('issues.index', ['project' => $project, 'state' => 'closed']) }}">
                Closed
            </a>
        </div>
    </div>
    <div class="w-full bg-white rounded-md shadow-md px-6">
        @foreach($issues as $issue)
            <li class="block py-3 border-b border-gray-200 last:border-b-0">
                <div class="flex justify-between">
                    <div>
                        <div class="font-bold flex items-center py-2">
                            <div class="underline">
                                <a href="{{ route('issues.show', ['project' => $project->id, 'issue' => $issue->gitlab_id]) }}">
                                    #{{ $issue->internal_id }} {{ $issue->title }}
                                </a>
                            </div>
                            <div class="material-symbols-outlined ml-2 hover:text-purple-700">
                                <a href="{{ route('time-entries.create', ['issue_id' => $issue->id]) }}" target="_blank" rel="noopener">play_circle</a>
                            </div>
                        </div>
                        <div class="text-sm text-gray-400 flex">
                            <div class="mr-4">{{ $issue->state }}</div>
                            @if($issue->author)
                                <div>Author <span class="text-gray-900">{{ $issue->author->name }}</span></div>
                            @endif
                        </div>
                        <div class="inline-flex mt-2 opacity-90 text-white">
                            @if(count($issue->labels) > 0)
                                @foreach($issue->labels as $label)
                                    <div
                                        style="background-color: {{ Arr::get($label, 'color', '') }}"
                                        class="mr-2 py-1 px-2 rounded-md text-xs
                                        {{ UtilService::isTextDark(Arr::get($label, 'color', '#eeeeee')) ? 'text-white' : 'text-black' }}">
                                        {{ Arr::get($label, 'title', '') }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="text-sm text-gray-400">
                        @isset($issue->assigned->name)
                            <div>Assigned to <span class="font-bold text-gray-900">{{ $issue->assigned->name }}</span></div>
                        @endisset
                        <div class="">Updated {{ $issue->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </li>
        @endforeach
    </div>
@endsection
