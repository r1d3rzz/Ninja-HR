<x-layout>
    <x-slot name="title">
        Ninja HR
    </x-slot>

    <div class="container p-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-12 col-lg-4">
                            <img src="{{asset('storage/'.$employee->profile)}}" alt="{{$employee->name}}"
                                class="img-thumbnail">
                        </div>
                        <div class="col-12 mt-3 mt-lg-0 col-lg-8">
                            <div class="card card-body bg-info-subtle">
                                <h1 class="h4">{{$employee->name}}</h1>
                                <div>
                                    <span class="me-2">
                                        <i class="fa-solid fa-id-card-clip"></i>
                                        {{$employee->employee_id}}
                                    </span>
                                </div>

                                <div>
                                    <span class="me-2">
                                        <i class="fa-regular fa-envelope"></i>
                                        {{$employee->email}}
                                    </span>
                                </div>

                                <div>
                                    <span class="me-2">
                                        <i class="fa-solid fa-briefcase"></i>
                                        {{$employee->department->title}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
