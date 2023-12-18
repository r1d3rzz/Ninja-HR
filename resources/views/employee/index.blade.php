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
                            <a href="{{ route('employees.create') }}" class="btn btn-sm btn-primary">
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
                                    <th class="no-sort">Actions</th>
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
                    columns: [{
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
                            data: 'actions',
                            name: 'actions',
                        },
                        {
                            data: 'updated_at',
                            name: 'updated_at',
                        },
                    ],
                    order: [
                        [7, 'desc']
                    ],
                    columnDefs: [{
                            target: "hidden",
                            visible: false,
                        },
                        {
                            target: "no-sort",
                            orderable: false,
                        }
                    ],
                    language: {
                        paginate: {
                            previous: "<i class='fa-solid fa-angles-left'></i>",
                            next: "<i class='fa-solid fa-angles-right'></i>"
                        },
                    }
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

                @if (session('updated'))
                    Toast.fire({
                        icon: "success",
                        title: "{{ session('updated') }}"
                    });
                @endif

                $(document).on("click", ".delete-btn", function(e) {
                    e.preventDefault();
                    var id = $(this).data("id");

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method:"DELETE",
                                url: `/employees/${id}`,
                            }).done(function(res){
                                table.ajax.reload();
                            });
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            });
                        }
                    });

                });
            });
        </script>
    </x-slot>
</x-layout>
