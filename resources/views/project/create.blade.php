<x-layout>
    <x-slot name='title'>
        Project | Create
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card card-body mb-5">
                    <form action="/projects" method="POST" id="project" enctype="multipart/form-data">
                        @csrf

                        <x-form.input name="title" />

                        <div class="mb-4">
                            <div><label class="fs-6 text-muted">Select Leaders</label></div>
                            <select class="select-ninja form-select" name="leaders[]"
                                multiple="multiple">
                                @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <div><label class="fs-6 text-muted">Select Members</label></div>
                            <select class="select-ninja form-select" name="members[]"
                                multiple="multiple">
                                @foreach ($employees as $employee)
                                <option value="{{$employee->id}}">{{$employee->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <x-form.textarea name="description"/>

                        <div class="mb-4">
                            <label for="images fs-6">Images <span class="text-muted">(Only PNG, JPG, JPEG)</span></label>
                            <input type="file" name="images[]" multiple id="images" class="form-control" accept="image/*">
                            <div id="preview" class="mt-2"></div>
                        </div>

                        <div class="mb-4">
                            <label for="files fs-6">Files <span class="text-muted">(Only PDF)</span></label>
                            <input type="file" name="files[]" multiple id="files" class="form-control" accept="application/pdf">
                        </div>

                        <x-form.input name="start_date" class="project_date"/>

                        <x-form.input name="deadline" class="project_date"/>

                        <div class="mb-4">
                            <select name="priority" class="form-select">
                                <option disabled selected>-- Select Project Priority --</option>
                                <option value="low">Low</option>
                                <option value="middle">Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <select name="status" class="form-select">
                                <option disabled selected>-- Select Project Status --</option>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="complete">Complete</option>
                            </select>
                        </div>

                        <button class="btn btn-primary">Create Project</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function(){
                $('#images').on('change',function(e){
                    let imagesLength = document.getElementById('images').files.length;
                    $('#preview').html('');
                    for(let i = 0; i < imagesLength; i++){
                        $('#preview').append(`<img src=${URL.createObjectURL(e.target.files[i])} class="img-thumbnail me-2" width="200px">`);
                    }
                });

                $('.project_date').daterangepicker({
                    "singleDatePicker": true,
                    "showDropdowns": true,
                    "opens": "center",
                    "autoApply": true,
                    "drops": "auto",
                    "locale": {
                        "format": "YYYY-MM-DD",
                    }
                });
            });
        </script>
        {!! JsValidator::formRequest('App\Http\Requests\StoreProject', '#project') !!}
    </x-slot>
</x-layout>
