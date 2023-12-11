<x-layout>
    <x-slot name="title">
        Employees
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col mx-auto">
                <div class="card p-0 mt-2">
                    <div class="card-body">
                        <div class="mb-4">
                            <a href="{{ route('employee.create') }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-plus-circle me-1"></i>
                                <span>Create</span>
                            </a>
                        </div>
                        <table class="table table-bordered display nowrap" id="employees" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Department</th>
                                    <th>Is Present?</th>
                                    <th class="hidden">Updated At</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            $(function() {
                var table = $('#employees').DataTable({
                    processing: true,
                    responsive: true,
                    serverSide: true,
                    ajax: "{{ route('employees.dbtable') }}",
                    columns: [
                        {
                            data: 'employee_id',
                            name: 'employee_id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'department_name',
                            name: 'department_name'
                        },
                        {
                            data: 'is_present',
                            name: 'is_present',
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at',
                        },
                    ],
                    order: [
                        [6, 'desc']
                    ],
                    columnDefs: [
                        {
                            target: "hidden",
                            visible: false,
                        }
                    ]
                });

                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });


                @if (session('created'))
                    Toast.fire({
                        icon: "success",
                        title: "{{ session('created') }}"
                    });
                @endif
                //24:12 012
            });
        </script>
    </x-slot>
</x-layout>
