<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployee;
use App\Http\Requests\UpdateEmployee;
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
                ->addColumn('actions', function ($each) {
                    $editIcon = '<a href="' . route("employees.edit", $each->id) . '" class="btn btn-sm btn-warning"><i class="fa-regular fa-pen-to-square"></i></a>';
                    $infoIcon = '<a href="' . route("employees.show", $each->id) . '" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-circle-info"></i></a>';

                    return "<div class='btn-group'>$editIcon $infoIcon</div>";
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
                ->rawColumns(['action', 'is_present', 'actions'])
                ->make(true);
        }
        return view('employee.index');
    }

    public function show($id)
    {
        return view("employee.show", [
            "employee" => User::findOrFail($id),
        ]);
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

        return redirect("/employees")->with("created", "Created Successful.");
    }

    public function edit($id)
    {
        $employee = User::findOrFail($id);
        return view("employee.edit", [
            "employee" => $employee,
            "departments" => Department::orderBy('title')->get(),
        ]);
    }

    public function update(UpdateEmployee $request)
    {
        $employee = User::findOrFail($request->id);
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
        $employee->password = $request->password ? $request->password : $employee->password;
        $employee->update();

        return redirect("/employees")->with("updated", "Updated Successful.");
    }
}
