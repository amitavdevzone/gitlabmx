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
            <x-input-text name="title" label="" value="{{ $delivery->title }}" placeholder="Enter the title of the Delivery" />
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
            <x-input-text name="description" label="" value="{{ $delivery->description }}" placeholder="Enter the description of the Delivery" />
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
            <x-input-date name="start_date" label="" value="{{ $delivery?->start_date?->format('Y-m-d') }}" placeholder="Enter the start date of the Delivery" />
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
            <x-input-date name="end_date" label="" value="{{ $delivery?->end_date?->format('Y-m-d') }}" placeholder="Enter the end date of the Delivery" />
            @error('end_date')
            <x-input-error message="{{$message}}" />
            @enderror
        </div>
    </div>
</div>
