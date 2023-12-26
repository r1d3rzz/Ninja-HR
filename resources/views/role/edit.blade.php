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

                        <div class="mb-4 row">
                            <label for="" class="fs-6 fw-bold mb-2">Permissions</label>
                            @foreach ($permissions as $permission)
                            <div class="form-check user-select-none col-12 col-lg-3">
                                <input name="permissions[]" class="form-check-input" type="checkbox"
                                    value="{{$permission->name}}" id="{{$permission->id}}"
                                    @if(in_array($permission->id,$old_permissions_id)) checked @endif/>
                                <label class="form-check-label" for="{{$permission->id}}">{{$permission->name}}</label>
                            </div>
                            @endforeach
                        </div>

                        <button class="btn btn-primary">Update Role</button>
                    </form>

                    {!! JsValidator::formRequest('App\Http\Requests\UpdateRole') !!}
                </div>
            </div>
        </div>
    </div>
</x-layout>
