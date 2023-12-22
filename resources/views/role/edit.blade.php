<x-layout>
    <x-slot name='title'>
        Role | Edit
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card card-body">
                    <form action="{{route('roles.update',$role->id)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <x-form.input name="name" value="{{$role->name}}" />

                        <button class="btn btn-primary">Update Role</button>
                    </form>

                    {!! JsValidator::formRequest('App\Http\Requests\UpdateRole') !!}
                </div>
            </div>
        </div>
    </div>
</x-layout>