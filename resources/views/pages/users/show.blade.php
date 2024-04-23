@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        View user details
    </div>
@endsection

@section('breadcrumb')
    @php
        $crumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Users', 'url' => route('users.index')],
            ['name' => $user->name]
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

        <form class="py-4 px-12" action="{{ route('users.update', ['user' => $user->id]) }}" method="post">
            {{ csrf_field() }}
            @method('PATCH')

            <!-- Name field -->
            <div class="flex mb-8 border-b pb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <strong>Name</strong>
                    <br>
                    <small>Name of the user - this is just display name.</small>
                </div>

                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-text name="name" label="" placeholder="Enter user's name here." value="{{ $user->name }}" />
                        @error('name')
                        <x-input-error message="{{$message}}" />
                        @enderror
                    </div>
                </div>
            </div>

            <!-- username field -->
            <div class="flex mb-8 border-b pb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <strong>Username</strong>
                    <br>
                    <small>Username of the user as per Gitlab</small>
                </div>

                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-text name="gitlab_username" label="" placeholder="Enter gitlab username here." value="{{ $user->gitlab_username }}" />
                        @error('gitlab_username')
                        <x-input-error message="{{$message}}" />
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Email field -->
            <div class="flex mb-8 border-b pb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <strong>Email</strong>
                    <br>
                    <small>Email of the user as per Gitlab</small>
                </div>

                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-text name="email" label="" placeholder="Enter email here." value="{{ $user->email }}" />
                        @error('email')
                        <x-input-error message="{{$message}}" />
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-center">
                <a href="{{ route('users.index') }}" class="mr-6">Back</a>
                <button class="btn btn-primary text-white rounded">Save</button>
            </div>
        </form>
    </div>
@endsection
