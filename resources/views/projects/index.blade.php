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

@section('content')
    <div class="overflow-x-auto bg-white rounded-md shadow-md p-6">
        <table class="table">
            <!-- head -->
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
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
                                <div class="text-xs">{{ $project->project_id }}</div>
                                <div class="text-xs opacity-50">{{ $project->visibility }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                            <span class="font-bold underline">
                                <a href="#">{{ $project->name }}</a>
                            </span>
                        <br/>
                        <span class="badge badge-ghost badge-sm">{{ $project->name_with_namespace }}</span>
                    </td>
                    <td>{{ ucfirst($project->updated_at->diffForHumans()) }}</td>
                    <th>
                        <a href="#" class="btn btn-ghost btn-xs">details</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $projects->links() }}
@endsection
