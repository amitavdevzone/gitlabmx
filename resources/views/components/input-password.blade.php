@props(['name', 'label', 'placeholder' => 'Enter value'])
<div class="w-full">
    <label for="{{ $name }}">{{ $label }}</label>
    <input
        class="input input-bordered w-full rounded shadow"
        type="password"
        name="{{$name}}"
        value="{{ old($name) }}"
        placeholder="{{ $placeholder }}"
        id="{{ $name }}" />
</div>
