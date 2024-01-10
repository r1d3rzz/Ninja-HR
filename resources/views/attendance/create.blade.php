<x-layout>
    <x-slot name='title'>
        Attendance | Create
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card card-body">
                    <x-errors_alert />
                    <form action="/attendances" method="POST" id="attendance">
                        @csrf

                        <div class="mb-4">
                            <x-label name="Employee" /><br>
                            <select class="select-ninja form-select" name="user_id">
                                <option disabled selected></option>
                                @foreach ($employees as $employee)
                                <option {{old('user_id')==$employee->id ? 'selected' : '' }}
                                    value="{{$employee->id}}">{{$employee->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <x-form.input name="date" />
                        <x-form.input name="checkin_time" class="check_time" />
                        <x-form.input name="checkout_time" class="check_time" />

                        <button class="btn btn-primary">Create Attendance</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function(){
                $('.select-ninja').select2({
                    placeholder: '-- Please Select Employee --'
                });

                $('#date').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "opens": "center",
                    "maxDate": moment(),
                    "autoApply": true,
                    "drops": "auto",
                    "locale": {
                        "format": "YYYY-MM-DD",
                    }
                });

                $('.check_time').daterangepicker({
                    "singleDatePicker": true,
                    "timePicker": true,
                    "timePicker24Hour": true,
                    "timePickerSeconds": true,
                    "locale": {
                        "format": "HH:mm:ss",
                    }
                }).on("show.daterangepicker",function(e,picker){
                    picker.container.find('.calendar-table').hide();
                });
            });

        </script>
        {!! JsValidator::formRequest('App\Http\Requests\StoreAttendance', '#attendance') !!}
    </x-slot>
</x-layout>