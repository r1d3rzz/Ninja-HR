@props(['name'])

<x-input-outline-wrapper>
    <textarea rows="1" id="{{ $name }}" class="form-control @error('{{ $name }}') is-invalid @enderror"
        name="{{ $name }}" required autocomplete="{{ $name }}" required>{{ old($name) }}</textarea>

    <x-label :name="$name" />

    <x-error :name="$name" />
</x-input-outline-wrapper>
