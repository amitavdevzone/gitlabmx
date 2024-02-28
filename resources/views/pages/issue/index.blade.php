@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Issue list
    </div>
@endsection

@section('content')
    <div class="w-full bg-white rounded-md shadow-md px-6">
        @foreach($issues as $issue)
            <li class="block py-3 border-b border-gray-200 last:border-b-0">
                <div class="flex justify-between">
                    <div>
                        <div class="font-bold">
                            <a class="underline" href="{{ route('issues.show', ['project' => $issue->project_id, 'issue' => $issue->gitlab_id]) }}">
                                #{{ $issue->internal_id }} {{ $issue->title }}
                            </a>
                        </div>
                        <div class="text-sm text-gray-400">{{ $issue->state }}</div>
                        <div class="inline-flex">
                            <div class="mr-2 rounded-md bg-gray-200 border-b border-b-gray-300 px-1 py-1">A</div>
                            <div>B</div>
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
