@extends('home')

@section('content')
    <ul>
        @foreach($projects as $project)
            <li>
                <div>
                    {{ $project->name }}
                    {{ $project->visibility }}
                </div>
            </li>
        @endforeach
    </ul>

    <div>
        {{ $projects->links() }}
    </div>
@endsection
