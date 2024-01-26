<div class="col-lg-3 mb-3 mb-lg-0">
    <div class="card">
        <div class="card-header text-bg-success">
            Pending
        </div>
        <div class="card-body alert-success p-3">
            @foreach (collect($project->tasks)->where('status','pending') as $task)
            <div class="card card-body py-2 px-3 mb-1">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fs-6 fw-bold">{{$task->title}}</div>
                    <div class="fs-6 mb-2">
                        <a href="#" id="task_edit" class="me-2" data-task="{{base64_encode(json_encode($task))}}" data-members="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}">
                            <i class="fa-solid fa-edit text-warning"></i>
                        </a>
                        <a href="#" id="task_delete" data-id="{{$task->id}}">
                            <i class="fa-solid fa-trash-alt text-danger"></i>
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="fs-6">
                        <i class="fa-solid fa-clock text-danger"></i>
                        <span class="fw-bold">
                            {{Carbon\Carbon::parse($task->start_date)->format("M d")}}
                        </span>
                        <br>
                        <div class="">
                            @if ($task->priority == "high")
                                <span class="badge bg-danger">{{ucfirst($task->priority)}}</span>
                            @elseif ($task->priority == "middle")
                                <span class="badge bg-warning">{{ucfirst($task->priority)}}</span>
                            @else
                                <span class="badge bg-primary">{{ucfirst($task->priority)}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="fs-5">
                        @foreach ($task->members as $member)
                            @if ($member->profile)
                                <img title="{{$member->name}}" src="{{asset('storage/'.$member->profile)}}" alt="{{$member->name}}" width="50" class="img-thumbanil">
                            @else
                                <img title="{{$member->name}}" src="/image/temp_profile_img.jpg" alt="{{$member->name}}" width="50" class="img-thumbanil">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            <a href="#" id="add_pending_task" class="card card-body p-2 text-center mt-2">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-plus-circle me-2"></i>
                    Add Task
                </div>
            </a>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-3 mb-lg-0">
    <div class="card">
        <div class="card-header text-bg-secondary">
            In Progress
        </div>
        <div class="card-body alert-secondary p-3">
            @foreach (collect($project->tasks)->where('status','in_progress') as $task)
            <div class="card card-body py-2 px-3 mb-1">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fs-6 fw-bold">{{$task->title}}</div>
                    <div class="fs-6 mb-2">
                        <a href="#" id="task_edit" class="me-2" data-task="{{base64_encode(json_encode($task))}}" data-members="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}">
                            <i class="fa-solid fa-edit text-warning"></i>
                        </a>
                        <a href="#" id="task_delete" data-id="{{$task->id}}">
                            <i class="fa-solid fa-trash-alt text-danger"></i>
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="fs-6">
                        <i class="fa-solid fa-clock text-danger"></i>
                        <span class="fw-bold">
                            {{Carbon\Carbon::parse($task->start_date)->format("M d")}}
                        </span>
                        <br>
                        <div class="">
                            @if ($task->priority == "high")
                                <span class="badge bg-danger">{{ucfirst($task->priority)}}</span>
                            @elseif ($task->priority == "middle")
                                <span class="badge bg-warning">{{ucfirst($task->priority)}}</span>
                            @else
                                <span class="badge bg-primary">{{ucfirst($task->priority)}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="fs-5">
                        @foreach ($task->members as $member)
                            @if ($member->profile)
                                <img title="{{$member->name}}" src="{{asset('storage/'.$member->profile)}}" alt="{{$member->name}}" width="50" class="img-thumbanil">
                            @else
                                <img title="{{$member->name}}" src="/image/temp_profile_img.jpg" alt="{{$member->name}}" width="50" class="img-thumbanil">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            <a href="#" id="add_in_progress_task" class="card card-body p-2 text-center mt-2">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-plus-circle me-2"></i>
                    Add Task
                </div>
            </a>
        </div>
    </div>
</div>

<div class="col-lg-3 mb-3 mb-lg-0">
    <div class="card">
        <div class="card-header text-bg-primary">
            Complete
        </div>
        <div class="card-body alert-primary p-3">
            @foreach (collect($project->tasks)->where('status','complete') as $task)
            <div class="card card-body py-2 px-3 mb-1">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fs-6 fw-bold">{{$task->title}}</div>
                    <div class="fs-6 mb-2">
                        <a href="#" id="task_edit" class="me-2" data-task="{{base64_encode(json_encode($task))}}" data-members="{{base64_encode(json_encode(collect($task->members)->pluck('id')->toArray()))}}">
                            <i class="fa-solid fa-edit text-warning"></i>
                        </a>
                        <a href="#" id="task_delete" data-id="{{$task->id}}">
                            <i class="fa-solid fa-trash-alt text-danger"></i>
                        </a>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-1">
                    <div class="fs-6">
                        <i class="fa-solid fa-clock text-danger"></i>
                        <span class="fw-bold">
                            {{Carbon\Carbon::parse($task->start_date)->format("M d")}}
                        </span>
                        <br>
                        <div class="">
                            @if ($task->priority == "high")
                                <span class="badge bg-danger">{{ucfirst($task->priority)}}</span>
                            @elseif ($task->priority == "middle")
                                <span class="badge bg-warning">{{ucfirst($task->priority)}}</span>
                            @else
                                <span class="badge bg-primary">{{ucfirst($task->priority)}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="fs-5">
                        @foreach ($task->members as $member)
                            @if ($member->profile)
                                <img title="{{$member->name}}" src="{{asset('storage/'.$member->profile)}}" alt="{{$member->name}}" width="50" class="img-thumbanil">
                            @else
                                <img title="{{$member->name}}" src="/image/temp_profile_img.jpg" alt="{{$member->name}}" width="50" class="img-thumbanil">
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            <a href="#" id="add_complete_task" class="card card-body p-2 text-center mt-2">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-plus-circle me-2"></i>
                    Add Task
                </div>
            </a>
        </div>
    </div>
</div>
