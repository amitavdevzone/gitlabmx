@props(['name', 'label', 'placeholder' => 'Enter value', 'value' => '', 'disabled' => false])
<div class="w-full">
    <label for="{{ $name }}">{{ $label }}</label>
    <input
        class="input input-bordered w-full rounded shadow"
        type="date"
        name="{{$name}}"
        value="{{ old($name) ?: $value ?: now()->format('Y-m-d') }}"
        placeholder="{{ $placeholder }}"
        id="{{ $name }}"
        {{ $disabled ? 'disabled' : '' }}
    />
</div>
