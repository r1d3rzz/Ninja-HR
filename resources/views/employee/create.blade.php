<x-layout>
    <x-slot name="title">
        Create Employee
    </x-slot>

    <div class="container p-2">
        <div class="row">
            <div class="col-md-8 mx-auto contentBody">
                <div class="card p-0 mt-2">
                    <div class="card-body">
                        <form method="POST" action="{{ route('employees.store') }}" id="create-form"
                            enctype="multipart/form-data">
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
                                            <option value="male" {{old("gender")=="male" ? "selected" : "" }}>Male
                                            </option>
                                            <option value="female" {{old("gender")=="female" ? "selected" : "" }}>Female
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <x-label name="roles" /><br>
                                        <select class="select-ninja form-select w-75" name="roles[]"
                                            multiple="multiple">
                                            @foreach ($roles as $role)
                                            <option value="{{$role->name}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                </div>
                                <div class="col-12 col-lg-6">
                                    <x-form.input name="birthday" />

                                    <x-form.input name="profile" type="file" />

                                    <div id="preview" class="mb-4"></div>

                                    <x-form.textarea name="address" />

                                    <div class="mb-4">
                                        <select name="department_id" id="department" class="form-select">
                                            <option disabled selected> - Select Department - </option>
                                            @foreach ($departments as $department)
                                            <option {{old("department_id")==$department->id ? "selected" : ""}}
                                                value="{{ $department->id }}">{{ $department->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <x-form.input name="date_of_join" />

                                    <div class="mb-4">
                                        <select name="is_present" id="is_present" class="form-select">
                                            <option disabled selected> - Is Present - </option>
                                            <option value="1" {{old("is_present")=="1" ? "selected" : "" }}>Yes</option>
                                            <option value="0" {{old("is_present")=="0" ? "selected" : "" }}>No</option>
                                        </select>
                                    </div>

                                    <x-form.input name="password" type="password" />
                                </div>
                            </div>

                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary w-lg-50">Create Employee</button>
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

            $('#profile').on('change',function(e){
                let file_length = document.getElementById('profile').files.length;
                $('#preview').html('');
                for(let i = 0; i < file_length; i++){
                    $('#preview').append(`<img src="${URL.createObjectURL(e.target.files[i])}" class="img-thumbnail"/>`);
                }
            });
        </script>
    </x-slot>
</x-layout>
