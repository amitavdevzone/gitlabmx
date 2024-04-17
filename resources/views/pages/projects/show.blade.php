@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        View {{ $project->name }} details
    </div>
@endsection

@section('breadcrumb')
    @php
        $crumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Projects', 'url' => route('projects.index')],
            ['name' => $project->name]
        ];
    @endphp
    @include('components.breadcrumb', $crumbs)
@endsection

@section('content')
    <div class="bg-white rounded-md shadow-md p-6 w-3/4">
        @if(session('success'))
            <div role="alert" class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form class="py-4 px-12" action="{{ route('projects.update', ['project' => $project->id]) }}" method="post">
            {{ csrf_field() }}
            @method('PATCH')

            <div class="flex mb-8 border-b pb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <strong>Project name</strong>
                    <br>
                    <small>Enter the name of the Client that you want to add.</small>
                </div>

                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-text name="name" label="" placeholder="Enter client name here." value="{{ $project->name }}" />
                        @error('name')
                            <x-input-error message="{{$message}}" />
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex mb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <strong>Client name</strong>
                    <br>
                    <small>Select the name to map this project.</small>
                </div>

                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <label>
                            <select name="client_id" class="select border-2 w-full rounded shadow px-2 py-2">
                                <option value="">Select option</option>
                                @foreach($clients as $client)
                                    <option
                                        {{ $client->id == $project->client_id ? 'selected' : '' }}
                                        value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button class="btn btn-primary text-white rounded">Save</button>
            </div>
        </form>
    </div>
@endsection
