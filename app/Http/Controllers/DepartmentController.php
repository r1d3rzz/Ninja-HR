<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index()
    {
        if (\request()->ajax()) {
            $data = Department::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('actions', function ($row) {
                    $editIcon = "<a href=" . route('departments.edit', $row->id) . " class='btn btn-sm btn-outline-warning'>" . "<i class='fa-solid fa-edit'></i>" . "</a>";
                    $deleteIcon = "<a href='#' data-id='$row->id' class='btn btn-sm btn-danger delete-btn'>" . "<i class='fa-solid fa-trash-alt'></i>" . "</a>";

                    return "<div class='btn-group'>$editIcon $deleteIcon</div>";
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action', 'actions'])
                ->make(true);
        }
        return view('department.index');
    }

    public function create()
    {
        return view('department.create');
    }

    public function store()
    {
        $formData = request()->validate([
            'title' => ['required', 'min:5', Rule::unique('departments', 'title')]
        ]);

        Department::create($formData);

        return redirect(route('departments.index'))->with('created', 'New Department is created Successful');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view('department.edit', [
            'department' => $department
        ]);
    }

    public function update($id)
    {
        $department = Department::findOrFail($id);

        request()->validate([
            'title' => ['required', 'min:5', Rule::unique('departments', 'title')->ignore($id)]
        ]);

        $department->title = request('title');
        $department->update();

        return redirect(route('departments.index'))->with('updated', 'Department is updated Successful');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return "success";
    }
}
