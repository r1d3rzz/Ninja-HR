<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        if (!User::find(auth()->id())->can('view_employees')) {
            return abort(401);
        }

        return view("employee.index");
    }

    public function ssd()
    {
        if (!User::find(auth()->id())->can('view_employees')) {
            return abort(401);
        }

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
                    $editIcon = '';
                    $infoIcon = '';
                    $deleteIcon = '';

                    if (User::find(auth()->id())->can('edit_employee')) {
                        $editIcon = '<a href="' . route("employees.edit", $each->id) . '" class="btn btn-sm btn-warning"><i class="fa-regular fa-pen-to-square"></i></a>';
                    }

                    if (User::find(auth()->id())->can('view_employees')) {
                        $infoIcon = '<a href="' . route("employees.show", $each->id) . '" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-circle-info"></i></a>';
                    }

                    if (User::find(auth()->id())->can('delete_employee')) {
                        $deleteIcon = '<a href="#" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-alt delete-btn" data-id="' . $each->id . '"></i></a>';
                    }

                    return "<div class='btn-group'>$editIcon $infoIcon $deleteIcon</div>";
                })
                ->addColumn('roles', function ($each) {
                    $lists = '';
                    foreach ($each->roles as $role) {
                        $lists .= "<span class='badge bg-primary m-1'>" . $role->name . "</span>";
                    }
                    return $lists;
                })
                ->editColumn('profile', function ($each) {
                    if ($each->profile) {
                        return "<div class='text-center'><img src='/storage/$each->profile' class='profile_img rounded-2'/><div class='mt=2 text-center'>$each->name</div></div>";
                    } else {
                        return "$each->name";
                    }
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
                ->rawColumns(['action', 'is_present', 'actions', 'profile', 'roles'])
                ->make(true);
        }
        return view('employee.index');
    }

    public function show($id)
    {
        if (!User::find(auth()->id())->can('view_employees')) {
            return abort(401);
        }

        return view("employee.show", [
            "employee" => User::findOrFail($id),
        ]);
    }

    public function create()
    {
        if (!User::find(auth()->id())->can('create_employee')) {
            return abort(401);
        }

        return view("employee.create", [
            "departments" => Department::orderBy("title")->get(),
            'roles' => Role::all(),
        ]);
    }

    public function store(StoreEmployee $request)
    {
        if (!User::find(auth()->id())->can('create_employee')) {
            return abort(401);
        }

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
        $employee->pin_code = $request->pin_code;

        if ($request->file("profile")) {
            $employee->profile = $request->file('profile')->store('Employee_Profiles');
        } else {
            $employee->profile = null;
        }

        $employee->save();

        $employee->syncRoles($request->roles);

        return redirect("/employees")->with("created", "Created Successful.");
    }

    public function edit($id)
    {
        if (!User::find(auth()->id())->can('edit_employee')) {
            return abort(401);
        }

        $employee = User::findOrFail($id);
        return view("employee.edit", [
            "employee" => $employee,
            "departments" => Department::orderBy('title')->get(),
            'roles' => Role::all(),
            'old_roles' => $employee->roles()->pluck('id')->toArray(),
        ]);
    }

    public function update(UpdateEmployee $request)
    {
        if (!User::find(auth()->id())->can('edit_employee')) {
            return abort(401);
        }

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
        $employee->pin_code = $request->pin_code;

        $employee->password = $request->password ? $request->password : $employee->password;
        if ($request->file("profile")) {
            if ($employee->profile) {
                Storage::disk('public')->delete($employee->profile);
            }
            $employee->profile = $request->file('profile')->store('Employee_Profiles');
        } else {
            $employee->profile;
        }
        $employee->update();

        $employee->syncRoles($request->roles);

        return redirect("/employees")->with("updated", "Updated Successful.");
    }

    public function destroy($id)
    {
        if (!User::find(auth()->id())->can('delete_employee')) {
            return abort(401);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return "success";
    }
}
