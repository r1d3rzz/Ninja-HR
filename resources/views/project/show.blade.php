<x-layout>
    <x-slot name="title">
        Projects | Detail
    </x-slot>

    <div class="container-fluid p-2 px-5">
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
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-body">
                    <div class="mb-2">
                        <div class="fs-5 fw-bold">Images</div>
                        <div>
                            @foreach ($project->images as $image)
                                <a href="{{asset('/storage/project/images/'.$image)}}" target="_blank">
                                    <img src="{{asset('/storage/project/images/'.$image)}}" class="img-thumbnail m-2" width="200">
                                </a>
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
    </div>
</x-layout>
