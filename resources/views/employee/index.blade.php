@extends("layouts.app")
@section("title","Employees")

@section("content")

<div class="card mt-2">
    <div class="card-body">
        <table class="table table-bordered" id="employees">
            <thead>
                <tr class="text-center">
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                    <th>Is Present?</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    $(function () {
        var table = $('#employees').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employees.dbtable') }}",
            columns: [
                {data: 'employee_id', name: 'employee_id'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'department_name', name: 'department_name'},
                {data: 'is_present', name: 'is_present',class:"text-center"},
            ]
        });
    });
</script>
@endsection