<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        return view("employee.index");
    }

    public function ssd()
    {
        if (\request()->ajax()) {
            $data = User::with("department")->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('department_name', function ($each) {
                    return $each->department ? $each->department->title : "-";
                })
                ->editColumn('is_present', function ($each) {
                    if ($each->is_present) {
                        return "<span class='badge bg-primary'>Present</span>";
                    } else {
                        return "<span class='badge bg-danger'>Leave</span>";
                    }
                })
                ->rawColumns(['action', 'is_present'])
                ->make(true);
        }
        return view('employee.index');
    }

    public function create()
    {
        return view("employee.create", [
            "departments" => Department::orderBy("title")->get(),
        ]);
    }
}
