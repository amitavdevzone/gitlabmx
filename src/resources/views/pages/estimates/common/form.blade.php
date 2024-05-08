<!-- The estimate name -->
<div class="flex mb-8 border-b pb-8">
    <div class="w-1/3 mr-8 flex flex-col">
        <div>
            <strong>Estimate title</strong>
            <br>
            <small>The title of the estimate</small>
        </div>
    </div>

    <div class="w-2/3 flex flex-col">
        <div class="mt-2 w-2/3">
            <x-input-text name="title" label="" value="{{ $estimate->title }}" />
            @error('title')
            <x-input-error message="{{ $message }}" />
            @enderror
        </div>
    </div>
</div>

<!-- The estimate desc -->
<div class="flex mb-8 border-b pb-8">
    <div class="w-1/3 mr-8 flex flex-col">
        <div>
            <strong>Estimate description</strong>
            <br>
            <small>The description of the estimate</small>
        </div>
    </div>

    <div class="w-2/3 flex flex-col">
        <div class="mt-2 w-2/3">
            <x-input-text name="description" label="" value="{{ $estimate->description }}" />
            @error('description')
            <x-input-error message="{{ $message }}" />
            @enderror
        </div>
    </div>
</div>

<!-- The estimate hours -->
<div class="flex mb-8 border-b pb-8">
    <div class="w-1/3 mr-8 flex flex-col">
        <div>
            <strong>Estimate hours</strong>
            <br>
            <small>The estimated hours for this item.</small>
        </div>
    </div>

    <div class="w-2/3 flex flex-col">
        <div class="mt-2 w-2/3">
            <x-input-text name="estimated_hours" label="" value="{{ $estimate->estimated_hours }}" />
            @error('estimated_hours')
            <x-input-error message="{{ $message }}" />
            @enderror
        </div>
    </div>
</div>
