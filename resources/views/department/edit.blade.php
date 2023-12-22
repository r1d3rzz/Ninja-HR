<x-layout>
    <x-slot name='title'>
        Department | Edit
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card card-body">
                    <form action="{{route('departments.update',$department->id)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <x-form.input name="title" value="{{$department->title}}" />

                        <button class="btn btn-primary">Update Department</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>