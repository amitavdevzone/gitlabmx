@extends('layout.app')

@section('title')
    <div class="text-lg font-bold">
        Create Delivery for "{{ $project->name }}"
    </div>
@endsection

@section('content')
    <div class="bg-white rounded-md shadow-md p-6 w-3/4">
        @if(session('success'))
            <div role="alert" class="alert alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form class="py-4 px-12" action="{{ route('deliveries.store', ['project' => $project]) }}" method="post">
            {{ csrf_field() }}

            <!-- The project name -->
            <div class="flex mb-8 border-b pb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <div>
                        <strong>Project name</strong>
                        <br>
                        <small>The project to which the Delivery is mapped to.</small>
                    </div>
                </div>

                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-text name="name" label="" value="{{ $project->name }}" disabled="true" />
                        @error('name')
                        <x-input-error message="{{$message}}" />
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Title -->
            <div class="flex mb-8 border-b pb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <div>
                        <strong>Title</strong>
                        <br>
                        <small>The name / identifier of the delivery</small>
                    </div>
                </div>

                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-text name="title" label="" placeholder="Enter the title of the Delivery" />
                        @error('title')
                        <x-input-error message="{{$message}}" />
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="flex mb-8 border-b pb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <div>
                        <strong>Description</strong>
                        <br>
                        <small>A little detail about the delivery</small>
                    </div>
                </div>

                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-text name="description" label="" placeholder="Enter the description of the Delivery" />
                        @error('description')
                        <x-input-error message="{{$message}}" />
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Start date -->
            <div class="flex mb-8 border-b pb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <div>
                        <strong>Start date</strong>
                        <br>
                        <small>When the delivery work will start</small>
                    </div>
                </div>

                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-date name="start_date" label="" placeholder="Enter the start date of the Delivery" />
                        @error('start_date')
                        <x-input-error message="{{$message}}" />
                        @enderror
                    </div>
                </div>
            </div>

            <!-- End date -->
            <div class="flex mb-8">
                <div class="w-1/3 mr-8 flex flex-col">
                    <div>
                        <strong>End date</strong>
                        <br>
                        <small>When the delivery work will need to be delivered.</small>
                    </div>
                </div>

                <div class="w-2/3 flex flex-col">
                    <div class="mt-2 w-2/3">
                        <x-input-date name="end_date" label="" placeholder="Enter the end date of the Delivery" />
                        @error('end_date')
                        <x-input-error message="{{$message}}" />
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button class="btn btn-primary text-white rounded">Save</button>
            </div>
        </form>
    </div>
@endsection
