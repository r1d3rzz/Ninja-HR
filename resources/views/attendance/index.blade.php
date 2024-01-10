<x-layout>
    <x-slot name="title">
        Attendances
    </x-slot>

    <div class="container employeesTable-container p-2">
        <div class="row">
            <div class="col mx-auto">
                <div class="card p-0 mt-2">
                    <div class="card-body">
                        <div class="mb-4">
                            <a href="{{ route('attendances.create') }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-plus-circle me-1"></i>
                                <span>Create</span>
                            </a>
                        </div>
                        <table class="table dbtable-align table-bordered display nowrap" id="attendances" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Checkin Time</th>
                                    <th>Checkout Time</th>
                                    <th class="no-sort">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <x-slot name="script">
            <script type="text/javascript">
                $(function () {
                    var table = $('#attendances').DataTable({
                        ajax: "{{ route('attendances.index') }}",
                        columns: [
                            {data: 'employee_name', name: 'employee_name'},
                            {data: 'date', name: 'date'},
                            {data: 'checkin_time', name: 'checkin_time'},
                            {data: 'checkout_time', name: 'checkout_time'},
                            {data: 'actions', name: 'actions',class:'text-center'},
                        ],
                        order: [[2, 'desc']]
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
                            title: "Are you sure delete this Attendance?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, delete it!"
                            }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    method:"DELETE",
                                    url: `/attendances/${id}`,
                                }).done(function(res){
                                    table.ajax.reload();
                                });
                                Swal.fire({
                                    title: "Attendance has been deleted.",
                                    icon: "success"
                                });
                            }
                        });

                    });
                });


            </script>
        </x-slot>
    </div>


</x-layout>