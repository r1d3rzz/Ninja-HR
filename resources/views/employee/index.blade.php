@extends("layouts.app")
@section("title","Employees")

@section("content")

<table class="table table-bordered" id="employees">
    <thead>
        <tr class="text-center">
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
        </tr>
    </thead>
</table>

@endsection

@section('script')
<script type="text/javascript">
    $(function () {
        var table = $('#employees').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employees.dbtable') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
            ]
        });
    });
</script>
@endsection