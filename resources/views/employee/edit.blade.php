<x-layout>
    <x-slot name="title">
        Update Employee
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto contentBody">
                <div class="card p-0 mt-2">
                    <div class="card-body">
                        <form method="POST" action="{{ route('employees.update',$employee->id) }}" id="edit-form"
                            enctype="multipart/form-data">
                            @csrf
                            @method("PUT")

                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <x-form.input name="id" value="{{$employee->id}}" hidden=true />

                                    <x-form.input name="employee_id" value="{{$employee->employee_id}}" />

                                    <x-form.input name="name" value="{{$employee->name}}" />

                                    <x-form.input name="phone" type="tel" value="{{$employee->phone}}" />

                                    <x-form.input name="email" type="email" value="{{$employee->email}}" />

                                    <x-form.input name="nrc_number" value="{{$employee->nrc_number}}" />

                                    <div class="mb-4">
                                        <select name="gender" id="gender" class="form-select">
                                            <option disabled selected> - Select Gender - </option>
                                            <option value="male" {{$employee->gender == "male" ? "selected" : ''}} >Male
                                            </option>
                                            <option value="female" {{$employee->gender == "female" ?
                                                "selected" : ''}}>Female
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <x-form.input name="birthday" value="{{$employee->birthday}}" />

                                    <x-form.input name="profile" type="file" />

                                    <div id="preview" class="mb-4">
                                        @if ($employee->profile)
                                        <img src="{{asset('storage/'.$employee->profile)}}" class="img-thumbnail"
                                            alt="{{$employee->name}}">
                                        @endif
                                    </div>

                                    <x-form.textarea name="address" value="{{$employee->address}}" />

                                    <div class="mb-4">
                                        <select name="department_id" id="department" class="form-select">
                                            <option disabled selected> - Select Department - </option>
                                            @foreach ($departments as $department)
                                            <option {{$department->id == $employee->department_id ? 'selected' : ''}}
                                                value="{{ $department->id }}">{{ $department->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <x-form.input name="date_of_join" value="{{$employee->date_of_join}}" />

                                    <div class="mb-4">
                                        <select name="is_present" id="is_present" class="form-select">
                                            <option disabled selected> - Is Present - </option>
                                            <option value="1" {{$employee->is_present == 1 ? "selected" : ''}}>Yes
                                            </option>
                                            <option value="0" {{$employee->is_present == 0 ? "selected" : ''}}>No
                                            </option>
                                        </select>
                                    </div>

                                    <x-form.input name="password" type="password" />
                                </div>
                            </div>

                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary w-50">Update Employee</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! JsValidator::formRequest('App\Http\Requests\UpdateEmployee', '#edit-form') !!}

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

            $("#profile").on('change',function(e){
                let img_length = document.getElementById('profile').files.length;
                $("#preview").html('');
                for(let i = 0; i < img_length; i++){
                    $("#preview").append(`<img src="${URL.createObjectURL(e.target.files[i])}" class="img-thumbnail" alt="preview"/>`);
                }
            });
        </script>
    </x-slot>
</x-layout>
