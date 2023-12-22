<x-layout>
    <x-slot name='title'>
        Department | Create
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card card-body">
                    <form action="/departments" method="POST">
                        @csrf

                        <x-form.input name="title" />

                        <button class="btn btn-primary">Create Department</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>