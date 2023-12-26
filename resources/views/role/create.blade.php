<x-layout>
    <x-slot name='title'>
        Role | Create
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="card card-body">
                    <form action="/roles" method="POST">
                        @csrf

                        <x-form.input name="name" />

                        <div class="mb-4 row">
                            <label for="" class="fs-6 fw-bold mb-2">Permissions</label>
                            @foreach ($permissions as $permission)
                            <div class="form-check user-select-none col-12 col-lg-3">
                                <input name="permissions[]" class="form-check-input" type="checkbox"
                                    value="{{$permission->name}}" id="{{$permission->id}}" />
                                <label class="form-check-label" for="{{$permission->id}}">{{$permission->name}}</label>
                            </div>
                            @endforeach
                        </div>

                        <button class="btn btn-primary">Create Role</button>
                    </form>

                    {!! JsValidator::formRequest('App\Http\Requests\StoreRole') !!}
                </div>
            </div>
        </div>
    </div>
</x-layout>
