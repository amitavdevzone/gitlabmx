@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Add an estimate to delivery for {{ $project->name }} // {{ $delivery->title }}
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

        <form class="py-4 px-12" action="{{ route('estimates.store', ['project' => $project, 'delivery' => $delivery]) }}" method="post">
            {{ csrf_field() }}

            @include('pages.estimates.common.form')

            <div class="flex justify-end">
                <button class="btn btn-primary text-white rounded">Save</button>
            </div>
        </form>
    </div>
@endsection
