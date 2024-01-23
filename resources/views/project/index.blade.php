<x-layout>
    <x-slot name="title">
        Projects
    </x-slot>

    <div class="container employeesTable-container p-2">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card p-0 mt-2">
                    <div class="card-body">
                        <div class="mb-4">
                            <a href="{{ route('projects.create') }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-plus-circle me-1"></i>
                                <span>Create</span>
                            </a>
                        </div>
                        <table class="table dbtable-align table-bordered" id="projects" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th class="no-sort">Leaders</th>
                                    <th class="no-sort">Members</th>
                                    <th>start Date</th>
                                    <th>Deadline</th>
                                    <th>Priority</th>
                                    <th>Status</th>
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
                    var table = $('#projects').DataTable({
                        ajax: "{{ route('projects.index') }}",
                        columns: [
                            {data: 'title', name: 'title'},
                            {data: 'description', name: 'description'},
                            {data: 'leaders', name: 'leaders'},
                            {data: 'members', name: 'members'},
                            {data: 'start_date', name: 'start_date'},
                            {data: 'deadline', name: 'deadline'},
                            {data: 'priority', name: 'priority'},
                            {data: 'status', name: 'status'},
                            {data: 'actions', name: 'actions',class:'text-center'},
                            {data: 'updated_at', name: 'updated_at',class:'text-center'},
                        ],
                        order: [[7, 'desc']]
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
                                    url: `/projects/${id}`,
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
