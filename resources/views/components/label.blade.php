@props(['name','hidden' => false])

@if ("$hidden" != "true")
<label class="form-label" for="{{$name}}">{{ucfirst($name)}}</label>
@endif