@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Project list
    </div>
    <div>
        <a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm rounded shadow text-white">Add
            project</a>
    </div>
@endsection

@section('breadcrumb')
    @php
        $crumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Projects'],
        ];
    @endphp
    @include('components.breadcrumb', $crumbs)
@endsection

@section('content')
    <div class="overflow-x-auto bg-white rounded-md shadow-md p-6">
        <table class="table">
            <!-- head -->
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Client</th>
                <th>Recent activity</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar">
                                <div class="mask mask-squircle w-8 h-8">
                                    <img src="https://daisyui.com/tailwind-css-component-profile-2@56w.png"
                                         alt="Avatar Tailwind CSS Component"/>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs">{{ $project->id }}</div>
                                <div class="text-xs opacity-50">{{ $project->visibility }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="font-bold underline">
                            <a href="{{ route('issues.index', ['project' => $project]) }}">{{ $project->name }}</a>
                        </span>
                        <br/>
                        <span class="badge badge-ghost badge-sm">{{ $project->name_with_namespace }}</span>
                    </td>
                    <td>{{ $project->client->name ?? '' }}</td>
                    <td>{{ ucfirst($project->updated_at->diffForHumans()) }}</td>
                    <th>
                        <div class="flex">
                            <div>
                                <a href="{{ route('deliveries.index', ['project' => $project->id]) }}" class="btn btn-ghost btn-xs">
                                    <span class="material-symbols-outlined">local_shipping</span>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('projects.show', ['project' => $project->id]) }}" class="btn btn-ghost btn-xs">details</a>
                            </div>
                        </div>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="pt-6">
        {{ $projects->links() }}
    </div>
@endsection
