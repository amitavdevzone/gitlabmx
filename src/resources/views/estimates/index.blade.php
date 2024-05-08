@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Estimate list
    </div>
    <div>
        <a href="{{ route('estimates.create', ['project' => $project, 'delivery' => $delivery]) }}"
           class="btn btn-primary btn-sm rounded shadow text-white">Add
            estimate</a>
    </div>
@endsection

@section('breadcrumb')
    @php
        $crumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Project', 'url' => route('projects.show', ['project' => $project])],
            ['name' => 'Delivery', 'url' => route('deliveries.index', ['project' => $project])],
            ['name' => $delivery->title],
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
                <th>#</th>
                <th></th>
                <th>Title</th>
                <th>Progress</th>
                <th>Estimated hours</th>
                <th>Completed hours</th>
            </tr>
            </thead>
            <tbody>
            @foreach($estimates as $estimate)
                <tr>
                    <td>{{ $estimate->id }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar">
                                <div class="mask mask-squircle w-8 h-8">
                                    <img src="https://daisyui.com/tailwind-css-component-profile-2@56w.png"
                                         alt="Avatar Tailwind CSS Component"/>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs">{{ $estimate->title }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $estimate->title }}</td>
                    <td>{{ $estimate->progress_percentage }}%</td>
                    <td>{{ $estimate->estimated_hours }}</td>
                    <td>{{ $estimate->completed_hours }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="pt-6">
        {{ $estimates->links() }}
    </div>
@endsection
