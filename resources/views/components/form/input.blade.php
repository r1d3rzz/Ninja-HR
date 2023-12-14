@props(['name', 'type' => 'text','value' => '','hidden'=>false])

<x-input-outline-wrapper :hidden="$hidden">
    <x-label :name="$name" :hidden="$hidden" />

    <input id="{{ $name }}" {{$hidden ? "hidden" : "" }} type="{{ $type }}" class="form-control" name="{{ $name }}"
        value="{{ old($name,$value) }}" required>

    <x-error :name="$name" />
</x-input-outline-wrapper>