<x-layout>
    <x-slot name='title'>
        Permission | Create
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card card-body">
                    <form action="/permissions" method="POST">
                        @csrf

                        <x-form.input name="name" />

                        <button class="btn btn-primary">Create Permission</button>
                    </form>

                    {!! JsValidator::formRequest('App\Http\Requests\StorePermission') !!}
                </div>
            </div>
        </div>
    </div>
</x-layout>
