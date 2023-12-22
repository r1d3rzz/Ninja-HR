<x-layout>
    <x-slot name='title'>
        Role | Create
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card card-body">
                    <form action="/roles" method="POST">
                        @csrf

                        <x-form.input name="name" />

                        <button class="btn btn-primary">Create Role</button>
                    </form>

                    {!! JsValidator::formRequest('App\Http\Requests\StoreRole') !!}
                </div>
            </div>
        </div>
    </div>
</x-layout>