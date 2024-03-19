@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Create client
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-md shadow-md p-6 w-3/4">
        @if(session('success'))
            <div role="alert" class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form class="py-4 px-12" action="{{ route('time-entries.store') }}" method="post">
            {{ csrf_field() }}
            @if(request()->has('issue_id'))
                <input type="hidden" name="issue_id" value="{{ request()->input('issue_id') }}">
            @endif
            <div class="flex mb-8">
                <h2 class="font-bold text-xl">
                    <a href="{{ route('issues.show', ['project' => $issue->project_id, 'issue' => $issue]) }}" target="_blank">
                        #{{ $issue->internal_id }} {{ $issue->title }}
                    </a>
                </h2>
            </div>
            <div class="flex mb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <strong>Description</strong>
                    <small>Description of the task that you have done.</small>
                </div>
                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-text name="description" label="" value="{{ $issue->title }}" placeholder="Enter task description" />
                    </div>
                </div>
            </div>
            <div class="flex mb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <strong>Time (in mins)</strong>
                    <small>Total time spent in mins.</small>
                </div>
                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-text name="time" label="" placeholder="Enter time in mins." />
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button class="btn btn-primary text-white rounded">Save</button>
            </div>
        </form>
    </div>
@endsection
