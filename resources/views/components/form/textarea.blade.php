@props(['name','value'=>''])

<x-input-outline-wrapper>
    <x-label :name="$name" />

    <textarea rows="3" id="{{ $name }}" class="form-control @error('{{ $name }}') is-invalid @enderror"
        name="{{ $name }}" required autocomplete="{{ $name }}" required>{{ old($name,$value) }}</textarea>

    <x-error :name="$name" />
</x-input-outline-wrapper>
