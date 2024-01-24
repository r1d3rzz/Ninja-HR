<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreProject;
use App\Http\Requests\UpdateProject;
use App\Models\ProjectLeader;
use App\Models\ProjectMember;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index()
    {
        if (!User::find(auth()->id())->can('view_projects')) {
            return abort(401);
        }

        if (\request()->ajax()) {
            $data = Project::with(['leaders', 'members'])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('leaders', function ($row) {
                    $leaders = '';
                    if (!$row->leaders) {
                        $leaders = "<img class='border border-1 rounded-5' src='/image/temp_profile_img.jpg' width='50' />";
                    }
                    foreach ($row->leaders as $leader) {
                        $leaders .= "<img title='" . $leader->name . "' class='border border-1 rounded-5' src=" . asset('storage') . '/' . $leader->profile . " width='40' height='40' />";
                    }
                    return "<div class='d-flex flex-wrap justify-content-center'>$leaders</div>";
                })
                ->addColumn('members', function ($row) {
                    $members = '';
                    if (!$row->members) {
                        $members = "<img class='border border-1 rounded-5' src='/image/temp_profile_img.jpg' width='50' />";
                    }
                    foreach ($row->members as $member) {
                        $members .= "<img title='" . $member->name . "' class='border border-1 rounded-5 m-1' src=" . asset('storage') . '/' . $member->profile . " width='40' height='40' />";
                    }
                    return "<div class='d-flex flex-wrap justify-content-center'>$members</div>";
                })
                ->editColumn('description', function ($row) {
                    return Str::limit($row->description, 100, '...');
                })
                ->editColumn('priority', function ($row) {
                    $priority = '';
                    if ($row->priority == 'high') {
                        $priority .= "<div class='badge bg-danger m-1 text-uppercase'>$row->priority</div>";
                    } elseif ($row->priority == 'middle') {
                        $priority .= "<div class='badge bg-warning m-1 text-uppercase'>$row->priority</div>";
                    } else {
                        $priority .= "<div class='badge bg-primary m-1 text-uppercase'>$row->priority</div>";
                    }
                    return $priority;
                })
                ->addColumn('actions', function ($row) {
                    $editIcon = '';
                    $deleteIcon = '';
                    $detailIcon = '';

                    if (User::find(auth()->id())->can('view_projects')) {
                        $detailIcon = "<a href=" . route('projects.show', $row->id) . " class='btn mb-1 btn-sm btn-outline-primary'>" . "<i class='fa-solid fa-eye'></i>" . "</a>";
                    }

                    if (User::find(auth()->id())->can('edit_project')) {
                        $editIcon = "<a href=" . route('projects.edit', $row->id) . " class='btn mb-1 btn-sm btn-warning'>" . "<i class='fa-solid fa-edit'></i>" . "</a>";
                    }

                    if (User::find(auth()->id())->can('delete_project')) {
                        $deleteIcon = "<a href='#' data-id='$row->id' class='btn btn-sm mb-1 btn-danger delete-btn'>" . "<i class='fa-solid fa-trash-alt'></i>" . "</a>";
                    }

                    return "<div>$detailIcon $editIcon $deleteIcon</div>";
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action', 'actions', 'leaders', 'members', 'priority'])
                ->make(true);
        }
        return view('project.index');
    }

    public function show($id)
    {
        if (!auth()->user()->can('view_projects') && !auth()->user()->can('view_my_projects')) {
            return abort(401);
        }

        return view('project.show', [
            'project' => Project::findOrFail($id),
        ]);
    }

    public function create()
    {
        if (!User::find(auth()->id())->can('create_project')) {
            return abort(401);
        }

        return view('project.create', [
            'employees' => User::orderBy('employee_id')->get(),
        ]);
    }

    public function store(StoreProject $request)
    {
        if (!User::find(auth()->id())->can('create_project')) {
            return abort(401);
        }

        $imagesNames = null;
        if ($request->hasFile('images')) {
            $imagesNames = [];
            $images_files = $request->file('images');
            foreach ($images_files as $image) {
                $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put('project/images/' . $imageName, file_get_contents($image));
                $imagesNames[] = $imageName;
            }
        }

        $filesNames = null;
        if ($request->hasFile('files')) {
            $filesNames = [];
            $files = $request->file('files');
            foreach ($files as $file) {
                $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('project/files/' . $fileName, file_get_contents($file));
                $filesNames[] = $fileName;
            }
        }

        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->images = $imagesNames;
        $project->files = $filesNames;
        $project->save();

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);

        return redirect(route('projects.index'))->with('created', 'New Project is created Successful');
    }

    public function edit($id)
    {
        if (!User::find(auth()->id())->can('edit_project')) {
            return abort(401);
        }

        $project = Project::findOrFail($id);

        return view('project.edit', [
            'project' => $project,
            'employees' => User::orderBy('employee_id')->get(),
        ]);
    }

    public function update(UpdateProject $request, $id)
    {
        if (!User::find(auth()->id())->can('edit_project')) {
            return abort(401);
        }

        $project = Project::findOrFail($id);

        $imagesNames = $project->images;
        if ($request->hasFile('images')) {
            $imagesNames = [];
            $images_files = $request->file('images');
            foreach ($images_files as $image) {
                $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('public')->put('project/images/' . $imageName, file_get_contents($image));
                $imagesNames[] = $imageName;
            }
        }

        $filesNames = $project->files;
        if ($request->hasFile('files')) {
            $filesNames = [];
            $files = $request->file('files');
            foreach ($files as $file) {
                $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
                Storage::disk('public')->put('project/files/' . $fileName, file_get_contents($file));
                $filesNames[] = $fileName;
            }
        }

        $project->title = $request->title;
        $project->description = $request->description;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->images = $imagesNames;
        $project->files = $filesNames;
        $project->update();

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);

        return redirect(route('projects.index'))->with('updated', 'Project is updated Successful');
    }

    public function destroy($id)
    {
        if (!User::find(auth()->id())->can('delete_project')) {
            return abort(401);
        }

        $project = Project::findOrFail($id);

        $projectLeaders = ProjectLeader::where('project_id', $project->id)->get();
        $projectMembers = ProjectMember::where('project_id', $project->id)->get();

        foreach ($projectLeaders as $leader) {
            $leader->delete();
        }

        foreach ($projectMembers as $member) {
            $member->delete();
        }

        $project->delete();

        return "success";
    }
}
