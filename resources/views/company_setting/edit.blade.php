<x-layout>
    <x-slot name="title">
        Company Setting
    </x-slot>

    <x-slot name="style">
        <style>
            .calendar-table {
                display: none
            }
        </style>
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-body">
                    <form action="{{route('company_settings.update',1)}}" method="POST" id="edit-form">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <x-company-setting-wrapper>
                                <x-form.input name="name" value="{{$setting->name}}" />
                            </x-company-setting-wrapper>

                            <x-company-setting-wrapper>
                                <x-form.input name="email" value="{{$setting->email}}" />
                            </x-company-setting-wrapper>

                            <x-company-setting-wrapper>
                                <x-form.input name="phone" value="{{$setting->phone}}" />
                            </x-company-setting-wrapper>

                            <x-company-setting-wrapper>
                                <x-form.textarea name="address" value="{{$setting->address}}" />
                            </x-company-setting-wrapper>

                            <x-company-setting-wrapper>
                                <x-form.input name="office_start_time" class="company_times"
                                    value="{{$setting->office_start_time}}" />
                            </x-company-setting-wrapper>

                            <x-company-setting-wrapper>
                                <x-form.input name="office_end_time" class="company_times"
                                    value="{{$setting->office_end_time}}" />
                            </x-company-setting-wrapper>

                            <x-company-setting-wrapper>
                                <x-form.input name="break_start_time" class="company_times"
                                    value="{{$setting->break_start_time}}" />
                            </x-company-setting-wrapper>

                            <x-company-setting-wrapper>
                                <x-form.input name="break_end_time" class="company_times"
                                    value="{{$setting->break_end_time}}" />
                            </x-company-setting-wrapper>

                            <button class="btn btn-sm btn-warning">Update Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {!! JsValidator::formRequest('App\Http\Requests\UpdateCompanySetting', '#edit-form') !!}

    <x-slot name="script">
        <script>
            $('.company_times').daterangepicker({
                "singleDatePicker": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "timePickerSeconds": true,
                "locale": {
                    "format": "HH:mm:ss"
                }
            })


        </script>
    </x-slot>

</x-layout>
