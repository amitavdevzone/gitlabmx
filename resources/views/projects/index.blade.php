@extends('home')

@section('content')
    <div class="overflow-x-auto">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>State</th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>{{ $project->project_id }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->visibility }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $projects->links() }}
    </div>
@endsection
