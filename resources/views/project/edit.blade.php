<x-layout>
    <x-slot name='title'>
        Project | Edit
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card card-body mb-5">
                    <form action="{{route('projects.update',$project->id)}}" method="POST" id="project" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <x-form.input name="title" value="{{$project->title}}"/>

                        <div class="mb-4">
                            <div><label class="fs-6 text-muted">Select Leaders</label></div>
                            <select class="select-ninja form-select" name="leaders[]"
                                multiple="multiple">
                                @foreach ($employees as $employee)
                                <option @selected(in_array($employee->id, collect($project->leaders)->pluck('id')->toArray())) value="{{$employee->id}}">{{$employee->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <div><label class="fs-6 text-muted">Select Members</label></div>
                            <select class="select-ninja form-select" name="members[]"
                                multiple="multiple">
                                @foreach ($employees as $employee)
                                <option @selected(in_array($employee->id, collect($project->members)->pluck('id')->toArray())) value="{{$employee->id}}">{{$employee->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <x-form.textarea name="description" value="{{$project->description}}"/>

                        <div class="mb-4">
                            <label for="images fs-6">Images <span class="text-muted">(Only PNG, JPG, JPEG)</span></label>
                            <input type="file" name="images[]" multiple id="images" class="form-control" accept="image/*">
                            <div id="preview" class="mt-2"></div>
                            @if ($project->images)
                            <div class="currentImages">
                                <div class="fs-6 text-bold mb-2">Current Images</div>
                                @foreach ($project->images as $image)
                                    <img src="{{asset('storage/project/images/'.$image)}}" class="img-thumbnail" width="200px">
                                @endforeach
                            </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="files fs-6">Files <span class="text-muted">(Only PDF)</span></label>
                            <input type="file" name="files[]" multiple id="files" class="form-control" accept="application/pdf">
                            @if ($project->files)
                            <div class="currentImages">
                                <div class="fs-6 text-bold mb-2">Current PDF Files</div>
                                <div class="d-flex">
                                    @foreach ($project->files as $file)
                                    <div class="text-center me-2 border p-2 rounded-3">
                                        <a href="{{asset('storage/project/files/'.$file)}}" class="fs-1" target="_blank">
                                            <i class="fa-solid fa-file-pdf px-2 text-danger"></i>
                                        </a>
                                        <div>File {{$loop->iteration}}</div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <x-form.input name="start_date" class="project_date" value="{{$project->start_date}}"/>

                        <x-form.input name="deadline" class="project_date" value="{{$project->deadline}}"/>

                        <div class="mb-4">
                            <select name="priority" class="form-select">
                                <option disabled selected>-- Select Project Priority --</option>
                                <option @selected($project->priority == 'low') value="low">Low</option>
                                <option @selected($project->priority == 'middle') value="middle">Medium</option>
                                <option @selected($project->priority == 'high') value="high">High</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <select name="status" class="form-select">
                                <option disabled selected>-- Select Project Status --</option>
                                <option @selected($project->status == 'pending') value="pending">Pending</option>
                                <option @selected($project->status == 'in_progress') value="in_progress">In Progress</option>
                                <option @selected($project->status == 'complete') value="complete">Complete</option>
                            </select>
                        </div>

                        <button class="btn btn-primary">Update Project</button>
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
