<x-layout>
    <x-slot name="title">
        Create Employee
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto contentBody">
                <div class="card p-0 mt-2">
                    <div class="card-body">
                        <form method="POST" action="{{ route('employee.store') }}" id="create-form">
                            @csrf

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <x-form.input name="employee_id" />

                                    <x-form.input name="name" />

                                    <x-form.input name="phone" type="tel" />

                                    <x-form.input name="email" type="email" />

                                    <x-form.input name="nrc_number" />

                                    <div class="mb-4">
                                        <select name="gender" id="gender" class="form-select">
                                            <option disabled selected> - Select Gender - </option>
                                            <option value="male">Male</option>
                                            <option value="male">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <x-form.input name="birthday" />

                                    <x-form.textarea name="address" />

                                    <div class="mb-4">
                                        <select name="department_id" id="department" class="form-select">
                                            <option disabled selected> - Select Department - </option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <x-form.input name="date_of_join" />

                                    <div class="mb-4">
                                        <select name="is_present" id="is_present" class="form-select">
                                            <option disabled selected> - Is Present - </option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>

                                    <x-form.input name="password" type="password" />
                                </div>
                            </div>

                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary w-50">Create Employee</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! JsValidator::formRequest('App\Http\Requests\StoreEmployee', '#create-form') !!}

    <x-slot name="script">
        <script>
            $('#birthday').daterangepicker({
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

            $('#date_of_join').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "opens": "center",
                "autoApply": true,
                "drops": "auto",
                "locale": {
                    "format": "YYYY-MM-DD",
                }
            });
        </script>
    </x-slot>
</x-layout>
