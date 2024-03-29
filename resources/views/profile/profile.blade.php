<x-layout>
    <x-slot name="title">
        Profile
    </x-slot>

    <div class="container p-2 mb-3">
        <div class="row">
            <div class="col col-lg-8 mx-auto">
                <div class="card mb-3" style="border-radius: .5rem;">
                    <div class="row g-0">
                        <div class="col-md-4 mb-5 p-1 gradient-custom text-center text-muted"
                            style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                            @if ($employee->profile)
                            <img src="{{asset('storage/'.$employee->profile)}}" alt="{{$employee->name}}"
                                class="img-fluid my-5 img-thumbnail m-0" />
                            @endif
                            <h5 class="{{!$employee->profile?'mt-5':''}}">{{$employee->name}}</h5>
                            <div class="roles mb-2">
                                @foreach ($employee->roles as $role)
                                <span class="badge bg-primary m-1">{{$role->name}}</span>
                                @endforeach
                            </div>
                            <p>{{$employee->department ? $employee->department->title : "-"}}</p>
                            <div class="d-flex justify-content-center mb-3">
                                <a href="#"><i class="fa-brands fa-github fa-lg me-3"></i></a>
                                <a href="#"><i class="fa-brands fa-linkedin fa-lg me-3"></i></a>
                                <a href="#"><i class="fa-regular fa-envelope fa-lg"></i></a>
                            </div>

                            @can('edit_employee')
                            <a href="/employees/{{$employee->id}}/edit" class="text-danger">
                                <span><i class="fa-solid fa-edit"></i></span>
                                Edit Employee
                            </a>
                            @endcan
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <h6 class="text-primary">Information</h6>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <h6>Employee ID</h6>
                                        <p class="text-muted">
                                            <span><i class="fa-solid fa-id-badge"></i></span>
                                            {{$employee->employee_id}}
                                        </p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Email</h6>
                                        <p class="text-muted">
                                            <span><i class="fa-regular fa-envelope"></i></span>
                                            {{$employee->email}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <h6>NRC Number</h6>
                                        <p class="text-muted">
                                            <span><i class="fa-solid fa-address-card"></i></span>
                                            {{$employee->nrc_number}}
                                        </p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Phone</h6>
                                        <p class="text-muted">
                                            <span><i class="fa-solid fa-mobile"></i></span>
                                            {{$employee->phone}}
                                        </p>
                                    </div>
                                </div>
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <h6>Birthday</h6>
                                        <p class="text-muted">
                                            <span><i class="fa-solid fa-cake-candles"></i></span>
                                            {{$employee->birthday}}
                                        </p>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Gender</h6>
                                        <p class="text-muted">
                                            @if ($employee->gender == "male")
                                            <span><i class="fa-solid fa-mars"></i></span>
                                            @else
                                            <span><i class="fa-solid fa-venus"></i></span>
                                            @endif
                                            {{ucfirst($employee->gender)}}
                                        </p>
                                    </div>
                                </div>
                                <h6 class="text-success">Company Information</h6>
                                <hr class="mt-0 mb-4">
                                <div class="row pt-1">
                                    <div class="col-6 mb-3">
                                        <h6>Is Present?</h6>
                                        @if ($employee->is_present)
                                        <div class="badge bg-primary">Yes</div>
                                        @else
                                        <div class="badge bg-danger">Leave</div>
                                        @endif
                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>Date of Join</h6>
                                        <p class="text-muted">
                                            <span><i class="fa-solid fa-briefcase"></i></span>
                                            {{$employee->date_of_join}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>