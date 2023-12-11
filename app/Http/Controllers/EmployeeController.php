<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployee;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
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
                ->editColumn('updated_at', function ($each) {
                    return Carbon::parse($each->updated_at)->format("Y-m-d H:i:s");
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

    public function store(StoreEmployee $request)
    {
        $employee = new User();
        $employee->employee_id = $request->employee_id;
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->email = $request->email;
        $employee->nrc_number = $request->nrc_number;
        $employee->gender = $request->gender;
        $employee->birthday = $request->birthday;
        $employee->address = $request->address;
        $employee->department_id = $request->department_id;
        $employee->date_of_join = $request->date_of_join;
        $employee->is_present = $request->is_present;
        $employee->password = $request->password;
        $employee->save();

        return redirect("/employee")->with("created", "Created Successful.");
    }
}
