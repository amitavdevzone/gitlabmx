@props(['name', 'label', 'placeholder' => 'Enter value', 'value' => ''])
<div class="w-full">
    <label for="{{ $name }}">{{ $label }}</label>
    <input
        class="input input-bordered w-full rounded shadow"
        type="text"
        name="{{$name}}"
        value="{{ old($name) ?? $value ?? '' }}"
        placeholder="{{ $placeholder }}"
        id="{{ $name }}" />
</div>
