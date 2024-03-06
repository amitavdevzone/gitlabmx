@extends('layout.app')

@section('content')
    <p>Please login</p>

    <form action="{{ route('login.handle') }}" method="post">

        {{ csrf_field() }}

        <div class="pt-8">
            <x-input-text
                label="Enter your email address"
                name="email"
                placeholder="Enter your email address" />
            @error('email')
            <x-input-error message="{{$message}}" />
            @enderror
        </div>

        <div class="pt-8">
            <x-input-password
                label="Enter your password"
                name="password"
                placeholder="Enter your password" />
            @error('password')
            <x-input-error message="{{$message}}" />
            @enderror
        </div>

        <div class="pt-8">
            <label for="remember">
                <input type="checkbox" name="remember" id="remember" /> Remember me
            </label>
        </div>

        <div class="pt-8">
            <button class="btn btn-primary">Login</button>
        </div>

    </form>
@endsection
