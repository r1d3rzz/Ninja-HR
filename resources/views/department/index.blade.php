<x-layout>
    <x-slot name="title">
        Departments
    </x-slot>

    <div class="container employeesTable-container p-2">
        <div class="row">
            <div class="col mx-auto">
                <div class="card p-0 mt-2">
                    <div class="card-body">
                        <div class="mb-4">
                            <a href="{{ route('departments.create') }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-plus-circle me-1"></i>
                                <span>Create</span>
                            </a>
                        </div>
                        <table class="table dbtable-align table-bordered display nowrap" id="departments" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th class="hidden"></th>
                                    <th>Title</th>
                                    <th class="no-sort"></th>
                                    <th class="hidden">updated_at</th>
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
                    var table = $('#departments').DataTable({
                        ajax: "{{ route('departments.index') }}",
                        columns: [
                            {data: 'id', name: 'id'},
                            {data: 'title', name: 'title'},
                            {data: 'actions', name: 'actions',class:'text-center'},
                            {data: 'updated_at', name: 'updated_at',class:'text-center'},
                        ],
                        order: [[0, 'desc']]
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
                                    url: `/departments/${id}`,
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
    </div>


</x-layout>