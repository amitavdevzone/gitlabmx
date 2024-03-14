@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Issue
    </div>
@endsection

@section('content')
    <livewire:gitlab-issue-view :project="$project" :issue="$issue" />
@endsection
