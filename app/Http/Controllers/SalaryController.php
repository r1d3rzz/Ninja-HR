<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalary;
use App\Http\Requests\UpdateSalary;
use App\Models\Salary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SalaryController extends Controller
{
    public function index()
    {
        if (!User::find(auth()->id())->can('view_salaries')) {
            return abort(401);
        }

        if (\request()->ajax()) {
            $data = Salary::with('employee')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('employee_name', function ($row) {
                    return $row->employee ? $row->employee->name : '-';
                })
                ->editColumn('month', function ($row) {
                    return Carbon::create(null, $row->month, 1)->format('F');
                })
                ->editColumn('amount', function ($row) {
                    return number_format($row->amount);
                })
                ->addColumn('actions', function ($row) {
                    $editIcon = '';
                    $deleteIcon = '';

                    if (User::find(auth()->id())->can('edit_salary')) {
                        $editIcon = "<a href=" . route('salaries.edit', $row->id) . " class='btn btn-sm btn-outline-warning'>" . "<i class='fa-solid fa-edit'></i>" . "</a>";
                    }

                    if (User::find(auth()->id())->can('delete_salary')) {
                        $deleteIcon = "<a href='#' data-id='$row->id' class='btn btn-sm btn-danger delete-btn'>" . "<i class='fa-solid fa-trash-alt'></i>" . "</a>";
                    }

                    return "<div class='btn-group'>$editIcon $deleteIcon</div>";
                })
                ->editColumn('updated_at', function ($row) {
                    return Carbon::parse($row->updated_at)->format('Y-m-d H:i:s');
                })
                ->rawColumns(['action', 'actions'])
                ->make(true);
        }
        return view('salary.index');
    }

    public function create()
    {
        if (!User::find(auth()->id())->can('create_salary')) {
            return abort(401);
        }

        return view('salary.create', [
            'employees' => User::orderBy('employee_id', 'desc')->get(),
        ]);
    }

    public function store(StoreSalary $request)
    {
        if (!User::find(auth()->id())->can('create_salary')) {
            return abort(401);
        }

        $salary = new Salary();
        $salary->user_id = $request->user_id;
        $salary->month = $request->month;
        $salary->year = $request->year;
        $salary->amount = $request->amount;
        $salary->save();

        return redirect(route('salaries.index'))->with('created', 'Employee Salary is created Successful');
    }

    public function edit($id)
    {
        if (!User::find(auth()->id())->can('edit_salary')) {
            return abort(401);
        }

        $salary = Salary::findOrFail($id);

        return view('salary.edit', [
            'salary' => $salary,
            'employees' => User::orderBy('employee_id', 'desc')->get(),
        ]);
    }

    public function update(UpdateSalary $request, $id)
    {
        if (!User::find(auth()->id())->can('edit_salary')) {
            return abort(401);
        }

        $salary = Salary::findOrFail($id);

        $salary->user_id = $request->user_id;
        $salary->month = $request->month;
        $salary->year = $request->year;
        $salary->amount = $request->amount;
        $salary->update();

        return redirect(route('salaries.index'))->with('updated', 'Salary is updated Successful');
    }

    public function destroy($id)
    {
        if (!User::find(auth()->id())->can('delete_salary')) {
            return abort(401);
        }

        $salary = Salary::findOrFail($id);
        $salary->delete();

        return "success";
    }
}
