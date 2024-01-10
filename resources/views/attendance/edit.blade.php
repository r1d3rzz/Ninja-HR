<x-layout>
    <x-slot name='title'>
        Attendance | Edit
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card card-body">
                    <x-errors_alert />
                    <form action="{{route('attendances.update',$attendance->id)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-label name="Employee" /><br>
                            <select class="select-ninja form-select" name="user_id">
                                <option disabled selected></option>
                                @foreach ($employees as $employee)
                                <option {{$employee->id == $attendance->user_id ? 'selected' : ''}}
                                    value="{{$employee->id}}">{{$employee->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <x-form.input name="date" value="{{$attendance->date}}" />
                        <x-form.input name="checkin_time" class="check_time"
                            value="{{Carbon\Carbon::parse($attendance->checkin_time)->format('H:i:s')}}" />
                        <x-form.input name="checkout_time" class="check_time"
                            value="{{Carbon\Carbon::parse($attendance->checkout_time)->format('H:i:s')}}" />

                        <button class="btn btn-primary">Update Attendance</button>
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
    </x-slot>
</x-layout>