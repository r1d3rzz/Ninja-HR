<x-layout>
    <x-slot name="title">
        Projects | Detail
    </x-slot>

    <x-slot name="style">
        <style>
            .sortable-ghost{
                background-color: rgba(186, 164, 164, 0.585);
                border: 3px dotted black;
                opacity: 0.4;
            }
        </style>
    </x-slot>

    <div class="container-fluid p-2 px-lg-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-body">
                    <div class="fs-4 fw-bold">{{$project->title}}</div>
                    <div class="fs-6 mb-2">
                        <span>Start Date: <span class="text-muted">{{$project->start_date}}</span></span>
                        <span>,</span>
                        <span>Deadline: <span class="text-muted">{{$project->deadline}}</span></span>
                    </div>
                    <div class="fs-6 mb-2">
                        <span>
                            Priority:
                            @if ($project->priority == 'high')
                            <span class="badge bg-danger">{{$project->priority}}</span>
                            @elseif ($project->priority == 'middle')
                            <span class="badge bg-warning">{{$project->priority}}</span>
                            @else
                            <span class="badge bg-primary">{{$project->priority}}</span>
                            @endif
                        </span>
                        <span>,</span>
                        <span>
                            Status:
                            @if ($project->status == 'in_progress')
                            <span class="badge bg-secondary">{{$project->status}}</span>
                            @elseif ($project->status == 'pending')
                            <span class="badge bg-success">{{$project->status}}</span>
                            @else
                            <span class="badge bg-primary">{{$project->status}}</span>
                            @endif
                        </span>
                    </div>
                    <div class="mb-2">
                        <div class="fs-5">Description</div>
                        <p class="fs-6 mt-2">
                            {{$project->description}}
                        </p>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-body">
                                    <div class="fs-5">Team Leaders</div>
                                    <div class="d-flex mt-3">
                                        @foreach ($project->leaders as $leader)
                                        <div class="text-center me-2">
                                            @if ($leader->profile)
                                            <img src="{{asset('storage/'.$leader->profile)}}" alt="{{$leader->name}}" width="60" height="60" class="mb-1">
                                            @else
                                            <img src="/image/temp_profile_img.jpg" alt="{{$leader->name}}" width="60" height="60" class="mb-1">
                                            @endif

                                            <small class="d-block">{{$leader->name}}</small>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card card-body">
                                    <div class="fs-5">Team Members</div>
                                    <div class="d-flex mt-3">
                                        @foreach ($project->members as $member)
                                        <div class="text-center me-2">
                                            @if ($member->profile)
                                            <img src="{{asset('storage/'.$member->profile)}}" alt="{{$member->name}}" width="60" height="60" class="mb-1">
                                            @else
                                            <img src="/image/temp_profile_img.jpg" alt="{{$member->name}}" width="60" height="60" class="mb-1">
                                            @endif

                                            <small class="d-block">{{$member->name}}</small>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-body mb-3 mb-lg-0">
                    <div class="mb-2">
                        <div class="fs-5 fw-bold">Images</div>
                        <div id="images">
                            @foreach ($project->images as $image)
                                <img src="{{asset('/storage/project/images/'.$image)}}" class="img-thumbnail m-2" width="100">
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="fs-5 fw-bold">Files</div>
                        <div class="d-flex text-center mt-3">
                            @foreach ($project->files as $file)
                                <a href="{{asset('/storage/project/files/'.$file)}}" target="_blank" class="me-3 text-decoration-none text-danger">
                                    <i class="fa-solid fa-file-pdf fs-1"></i>
                                    <div class="fs-5 text-dark">File {{$loop->iteration}}</div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-5">
            <h3 class="mt-3">Tasks</h3>
            <div id="tasks-data" class="row"></div>
        </div>
    </div>

    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script>
            $(document).ready(function(){
                var leaders = @json($project->leaders);
                var members = @json($project->members);
                var project_id = {{$project->id}};

                new Viewer(document.getElementById('images'));

                getTasksData();

                function getTasksData(){
                    $.ajax({
                        url: `/tasks-data?project_id=${project_id}`,
                        type: "GET",
                        success: function(res){
                            $('#tasks-data').html(res);
                            sortableTask();
                        },
                    });
                }

                function sortableTask(){
                    var pandingTasks = document.getElementById('pandingTasks');
                    var inProgressTasks = document.getElementById('inProgressTasks');
                    var completeTasks = document.getElementById('completeTasks');

                    Sortable.create(pandingTasks,{
                        group: "tasksBoard",
                        animation: 200,
                        ghostClass: "sortable-ghost",
                        store: {
                            set:function(sortable){
                                var order = sortable.toArray();
                                localStorage.setItem("pandingTasks",order.join(','));
                            }
                        },
                        onSort: function(e){
                            setTimeout(() => {
                                var pandingTasks = localStorage.getItem("pandingTasks");

                                $.ajax({
                                    url: `/tasks-draggable?project_id=${project_id}&pandingTasks=${pandingTasks}`,
                                    type: "GET",
                                });
                            }, 1000);
                        }
                    });

                    Sortable.create(inProgressTasks,{
                        group: "tasksBoard",
                        animation: 200,
                        store: {
                            set:function(sortable){
                                var order = sortable.toArray();
                                localStorage.setItem("inProgressTasks",order.join(','));
                            }
                        },
                        onSort: function(e){
                            setTimeout(() => {
                                var inProgressTasks = localStorage.getItem("inProgressTasks");

                                $.ajax({
                                    url: `/tasks-draggable?project_id=${project_id}&inProgressTasks=${inProgressTasks}`,
                                    type: "GET",
                                });
                            }, 1000);
                        }
                    });

                    Sortable.create(completeTasks,{
                        group: "tasksBoard",
                        animation: 200,
                        store: {
                            set:function(sortable){
                                var order = sortable.toArray();
                                localStorage.setItem("completeTasks",order.join(','));
                            }
                        },
                        onSort: function(e){
                            setTimeout(() => {
                                var completeTasks = localStorage.getItem("completeTasks");

                                $.ajax({
                                    url: `/tasks-draggable?project_id=${project_id}&completeTasks=${completeTasks}`,
                                    type: "GET",
                                });
                            }, 1000);
                        }
                    });
                }

                function storeTask(taskStatusValue,title){
                    var task_members_options = '';

                    leaders.forEach(function(leader){
                        task_members_options += `<option value="${leader.id}">${leader.name}</option>`;
                    });

                    members.forEach((member)=>{
                        task_members_options += `<option value="${member.id}">${member.name}</option>`;
                    });

                    Swal.fire({
                        title: `Add ${title} Task`,
                        showCancelButton: true,
                        html: `
                            <form id="formData">
                                <div class="text-start">
                                    <input type="hidden" name="project_id" value="${project_id}"/>
                                    <input type="hidden" name="status" value="${taskStatusValue}"/>
                                    <x-form.input name="title"/>
                                    <x-form.textarea name="description"/>
                                    <x-form.input name="start_date" class="task_date"/>
                                    <x-form.input name="deadline" class="task_date"/>

                                    <div class="mb-4">
                                        <div><label class="fs-6 text-muted">Select Members</label></div>
                                        <select class="select-ninja form-select" name="members[]"
                                            multiple="multiple">
                                            ${task_members_options}
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <div><label class="fs-6 text-muted">Select Priority</label></div>
                                        <select name="priority" class="form-select select-ninja">
                                            <option value="low">Low</option>
                                            <option value="middle">Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        `,
                        confirmButtonText: "Save"
                    }).then((result) => {
                        if (result.isConfirmed) {
                                var pendingFormData = $('#formData').serialize();
                                $.ajax({
                                    url: "{{route('tasks.store')}}",
                                    type: "POST",
                                    data: pendingFormData,
                                    success: function(res){
                                        getTasksData();
                                    },
                                });
                                Swal.fire({
                                title: "Saved",
                                text: "Your task has been saved.",
                                icon: "success"
                            });
                        }
                    });

                    $('.task_date').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "opens": "center",
                        "autoApply": true,
                        "drops": "auto",
                        "locale": {
                            "format": "YYYY-MM-DD",
                        }
                    });

                    $('.select-ninja').select2();
                }

                $(document).on('click','#add_pending_task',function(e){
                    e.preventDefault();
                    storeTask('pending','Pending');
                });

                $(document).on('click','#add_in_progress_task',function(e){
                    e.preventDefault();
                    storeTask('in_progress','In Progress');
                });

                $(document).on('click','#add_complete_task',function(e){
                    e.preventDefault();
                    storeTask('complete','Complete');
                });

                $(document).on('click','#task_edit',function(e){
                    e.preventDefault();
                    var taskData = JSON.parse(atob($(this).data('task')));
                    var membersData = JSON.parse(atob($(this).data('members')));

                    var task_members_options = '';

                    leaders.forEach(function(leader){
                        task_members_options += `<option ${membersData.includes(leader.id) ? 'selected' : ''} value="${leader.id}">${leader.name}</option>`;
                    });

                    members.forEach((member)=>{
                        task_members_options += `<option ${membersData.includes(member.id) ? 'selected' : ''} value="${member.id}">${member.name}</option>`;
                    });

                    Swal.fire({
                        title: `Edit Task`,
                        showCancelButton: true,
                        html: `
                            <form id="editFormData">
                                <div class="text-start">
                                    <input type="hidden" name="project_id" value="${taskData.id}"/>
                                    <input type="hidden" name="status" value="${taskData.status}"/>
                                    <x-form.input name="title" value="${taskData.title}"/>
                                    <x-form.textarea name="description" value="${taskData.description}"/>
                                    <x-form.input name="start_date" class="task_date" value="${taskData.start_date}"/>
                                    <x-form.input name="deadline" class="task_date" value="${taskData.deadline}"/>

                                    <div class="mb-4">
                                        <div><label class="fs-6 text-muted">Select Members</label></div>
                                        <select class="select-ninja form-select" name="members[]"
                                            multiple="multiple">
                                            ${task_members_options}
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <div><label class="fs-6 text-muted">Select Priority</label></div>
                                        <select name="priority" class="form-select select-ninja">
                                            <option ${taskData.priority == 'low' ? 'selected' : ''} value="low">Low</option>
                                            <option ${taskData.priority == 'middle' ? 'selected' : ''} value="middle">Medium</option>
                                            <option ${taskData.priority == 'high' ? 'selected' : ''} value="high">High</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        `,
                        confirmButtonText: "Save"
                    }).then((result) => {
                        if (result.isConfirmed) {
                                var editFormData = $('#editFormData').serialize();
                                $.ajax({
                                    url: "/tasks/"+taskData.id,
                                    type: "PUT",
                                    data: editFormData,
                                    success: function(res){
                                        getTasksData();
                                    },
                                });
                                Swal.fire({
                                title: "Saved",
                                text: "Your task has been saved.",
                                icon: "success"
                            });
                        }
                    });

                    $('.task_date').daterangepicker({
                        "singleDatePicker": true,
                        "showDropdowns": true,
                        "opens": "center",
                        "autoApply": true,
                        "drops": "auto",
                        "locale": {
                            "format": "YYYY-MM-DD",
                        }
                    });

                    $('.select-ninja').select2();
                });

                $(document).on('click','#task_delete',function(e){
                   e.preventDefault();
                   var id = $(this).data('id');

                   Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method:"DELETE",
                                url: `/tasks/${id}`,
                            }).done(function(res){
                                getTasksData();
                            });
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your task has been deleted.",
                                icon: "success"
                            });
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-layout>
