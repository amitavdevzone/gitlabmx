@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Fetch Project from Gitlab
    </div>
@endsection

@section('breadcrumb')
    @php
        $crumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Project', 'url' => route('projects.index')],
            ['name' => 'Fetch project']
        ];
    @endphp
    @include('components.breadcrumb', $crumbs)
@endsection

@section('content')
    <div class="bg-white rounded-md shadow-md p-6 w-3/4">
        @if(session('success'))
            <div role="alert" class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('projects.store') }}" method="post">
            {{ csrf_field() }}
            <div class="flex mb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <div>
                        <strong>Project ID</strong>
                        <br>
                        <small>Enter the project ID so that we can fetch the information from Gitlab</small>
                    </div>
                </div>

                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-text name="project_id" label="" placeholder="Enter gitlab project id here."/>
                        @error('project_id')
                            <x-input-error message="{{$message}}"/>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="flex justify-end">
                <button class="btn btn-primary text-white rounded">Save</button>
            </div>
        </form>
    </div>
@endsection
