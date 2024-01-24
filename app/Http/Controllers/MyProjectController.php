<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MyProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (\request()->ajax()) {
            $data = Project::with(['leaders', 'members']);

            $data
                ->whereHas('leaders', function ($query) {
                    $query->where('user_id', auth()->id());
                })->orWhereHas('members', function ($query) {
                    $query->where('user_id', auth()->id());
                });
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
                    $detailIcon = '';

                    if (User::find(auth()->id())->can('view_my_projects')) {
                        $detailIcon = "<a href=" . route('my-projects.show', $row->id) . " class='btn mb-1 btn-sm btn-outline-primary'>" . "<i class='fa-solid fa-eye'></i>" . "</a>";
                    }

                    return "<div>$detailIcon</div>";
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action', 'actions', 'leaders', 'members', 'priority'])
                ->make(true);
        }
        return view('project.my-projects');
    }

    public function show($id)
    {
        $project = Project::where('id', $id)
            ->where(function ($query) {
                $query
                    ->whereHas('leaders', function ($query) {
                        $query->where('user_id', auth()->id());
                    })
                    ->orWhereHas('members', function ($query) {
                        $query->where('user_id', auth()->id());
                    });
            })->findOrFail($id);

        return view('project.my-projects-show', [
            'project' => $project
        ]);
    }
}
