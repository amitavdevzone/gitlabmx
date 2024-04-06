@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Delivery list
    </div>
    <div>
        <a href="{{ route('deliveries.create', ['project' => $project]) }}"
           class="btn btn-primary btn-sm rounded shadow text-white">Add
            delivery</a>
    </div>
@endsection

@section('content')
    <div class="overflow-x-auto bg-white rounded-md shadow-md p-6">
        <table class="table">
            <!-- head -->
            <thead>
            <tr>
                <th></th>
                <th>Title</th>
                <th>Starts on</th>
                <th>Ends on</th>
                <th>Progress</th>
                <th>Estimated hours</th>
                <th>Completed hours</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($deliveries as $delivery)
                <tr>
                    <td>{{ $delivery->id }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar">
                                <div class="mask mask-squircle w-8 h-8">
                                    <img src="https://daisyui.com/tailwind-css-component-profile-2@56w.png"
                                         alt="Avatar Tailwind CSS Component"/>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs">{{ $delivery->title }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $delivery->start_date->format('Y-m-d') }}</td>
                    <td>{{ $delivery->end_date->format('Y-m-d') }}</td>
                    <td>{{ $delivery->progress_complete }}</td>
                    <td>{{ $delivery->estimated_hours }}</td>
                    <td>{{ $delivery->completed_hours }}</td>
                    <td>
                        <div class="flex">
                            <div class="pr-4">
                                <a href="{{ route('estimates.index', ['project' => $project, 'delivery' => $delivery]) }}">
                                    <span class="material-symbols-outlined">av_timer</span>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('deliveries.edit', ['project' => $project, 'delivery' => $delivery]) }}">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="pt-6">
        {{ $deliveries->links() }}
    </div>
@endsection
