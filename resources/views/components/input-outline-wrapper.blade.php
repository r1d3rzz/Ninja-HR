@props(['hidden' => false])

<div data-mdb-input-init class="form {{$hidden ? " " : " mb-4" }}">
    {{$slot}}
</div>