@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Users list
    </div>
    <div>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm rounded shadow text-white">Add user</a>
    </div>
@endsection

@section('breadcrumb')
    @php
        $crumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Users'],
        ];
    @endphp
    @include('components.breadcrumb', $crumbs)
@endsection

@section('content')
    <div class="overflow-x-auto bg-white rounded-md shadow-md p-6">
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
        <table class="table">
            <!-- head -->
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Username</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="avatar">
                                <div class="mask mask-squircle w-8 h-8">
                                    <img src="{{ $user->gitlab_data['avatar_url'] ?? 'https://daisyui.com/tailwind-css-component-profile-2@56w.png' }}"
                                         alt="Avatar Tailwind CSS Component"/>
                                </div>
                            </div>
                            <div>
                                <div class="text-xs">#{{ $user->gitlab_id }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="font-bold underline">
                            <a href="{{ route('clients.show', ['client' => $user]) }}">{{ $user->name }}</a>
                        </span>
                    </td>
                    <td>{{ $user->gitlab_username }}</td>
                    <th>
                        <a href="#"
                           class="btn btn-ghost btn-xs">details</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
@endsection
