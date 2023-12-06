@props(['name', 'type' => 'text'])

<x-input-outline-wrapper>
    <input id="{{ $name }}" type="{{ $type }}"
        class="form-control @error('{{ $name }}') is-invalid @enderror" name="{{ $name }}"
        value="{{ old($name) }}" required autocomplete="{{ $name }}" required>

    <x-label :name="$name" />

    <x-error :name="$name" />
</x-input-outline-wrapper>
