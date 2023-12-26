<x-layout>
    <x-slot name='title'>
        Permission | Edit
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card card-body">
                    <form action="{{route('permissions.update',$permission->id)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <x-form.input name="name" value="{{$permission->name}}" />

                        <button class="btn btn-primary">Update Permission</button>
                    </form>

                    {!! JsValidator::formRequest('App\Http\Requests\UpdatePermission') !!}
                </div>
            </div>
        </div>
    </div>
</x-layout>
