<x-layout>
    <x-slot name="title">
        Ninja HR
    </x-slot>

    <div class="container p-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body row">
                        @if ($employee->profile)
                        <div class="col-lg-4">
                            <img src="{{asset('storage/'.$employee->profile)}}" alt="{{$employee->name}}"
                                class="img-thumbnail">
                        </div>
                        @endif
                        <div class="col mt-3 mt-lg-0">
                            <div class="card card-body bg-info-subtle">
                                <h1 class="h4 mb-0">{{$employee->name}}</h1>
                                <div class="roles mb-2">
                                    @foreach ($employee->roles as $role)
                                    <span class="badge bg-primary m-1">{{$role->name}}</span>
                                    @endforeach
                                </div>
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

                <div class="card card-body p-3 mt-3">
                    <a href="#" id="logout-btn" class="btn btn-danger"><i class="fa-solid fa-right-from-bracket"></i>
                        Logout</a>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(function () {
                $('#logout-btn').click(function (e) {
                    e.preventDefault();
                    Swal.fire({
                    title: "Are you sure?",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Logout"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                type: "POST",
                                url: "/logout",
                                success: function (response) {
                                    window.location.reload();
                                }
                            });
                        }
                    });
                });
             });
        </script>
    </x-slot>
</x-layout>
