<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendance;
use App\Http\Requests\UpdateAttendance;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class AttendanceController extends Controller
{
    public function index()
    {
        if (!User::find(auth()->id())->can('view_attendances')) {
            return abort(401);
        }

        if (\request()->ajax()) {
            $data = Attendance::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('employee_name', function ($row) {
                    return $row->employee ? $row->employee->name : '-';
                })
                ->addColumn('actions', function ($row) {
                    $editIcon = '';
                    $deleteIcon = '';

                    if (User::find(auth()->id())->can('edit_attendance')) {
                        $editIcon = "<a href=" . route('attendances.edit', $row->id) . " class='btn btn-sm btn-outline-warning'>" . "<i class='fa-solid fa-edit'></i>" . "</a>";
                    }

                    if (User::find(auth()->id())->can('delete_attendance')) {
                        $deleteIcon = "<a href='#' data-id='$row->id' class='btn btn-sm btn-danger delete-btn'>" . "<i class='fa-solid fa-trash-alt'></i>" . "</a>";
                    }

                    return "<div class='btn-group'>$editIcon $deleteIcon</div>";
                })
                ->rawColumns(['action', 'actions'])
                ->make(true);
        }
        return view('attendance.index');
    }

    public function create()
    {
        if (!User::find(auth()->id())->can('create_attendance')) {
            return abort(401);
        }

        return view('attendance.create', ['employees' => User::orderBy('employee_id', 'desc')->get()]);
    }

    public function store(StoreAttendance $request)
    {
        if (!User::find(auth()->id())->can('create_attendance')) {
            return abort(401);
        }

        if (Attendance::where('user_id', $request->user_id)->where('date', $request->date)->exists()) {
            return back()->withErrors(["fail" => "Already defined!"])->withInput();
        }

        $attendance = new Attendance;
        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->checkin_time = $request->date . ' ' . $request->checkin_time;
        $attendance->checkout_time = $request->date . ' ' . $request->checkout_time;
        $attendance->save();

        return redirect(route('attendances.index'))->with('created', 'New Attendance is created Successful');
    }

    public function edit($id)
    {
        if (!User::find(auth()->id())->can('edit_attendance')) {
            return abort(401);
        }

        $attendance = Attendance::findOrFail($id);

        return view('attendance.edit', [
            'employees' => User::orderBy('employee_id', 'desc')->get(),
            'attendance' => $attendance,
        ]);
    }

    public function update($id, UpdateAttendance $request)
    {
        if (!User::find(auth()->id())->can('edit_attendance')) {
            return abort(401);
        }

        $attendance = Attendance::findOrFail($id);

        if (Attendance::where('user_id', $request->user_id)->where('date', $request->date)->where('id', '!=', $attendance->id)->exists()) {
            return back()->withErrors(['fail' => 'Already defined.'])->withInput();
        }

        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->checkin_time = $request->date . ' ' . $request->checkin_time;
        $attendance->checkout_time = $request->date . ' ' . $request->checkout_time;
        $attendance->update();

        return redirect(route('attendances.index'))->with('updated', 'Attendance is updated Successful');
    }

    public function checkincheckoutHandler()
    {
        return view('attendance.checkin-checkout', [
            'hash_value' => Hash::make(date('Y-m-d')),
        ]);
    }

    public function checkIncheckOut(Request $request)
    {
        $user = User::where('pin_code', $request->pin_code)->first();

        if (!$user) {
            return [
                "status" => 'fail',
                "message" => "Pin Code is Wrong!",
            ];
        }

        $checkin_checkout_data = Attendance::firstOrCreate(
            [
                "user_id" => $user->id,
                "date" => now()->format('Y-m-d'),
            ]
        );

        if (!is_null($checkin_checkout_data->checkin_time) && !is_null($checkin_checkout_data->checkout_time)) {
            return [
                "status" => 'fail',
                "message" => "Already Checkin and Checkout for Today!",
            ];
        }

        if (is_null($checkin_checkout_data->checkin_time)) {
            $checkin_checkout_data->checkin_time = now();
            $message = "Succesfully Checkin at " . now();
        } else {
            if (is_null($checkin_checkout_data->checkout_time)) {
                $checkin_checkout_data->checkout_time = now();
                $message = "Succesfully Checkout at " . now();
            }
        }

        $checkin_checkout_data->update();

        return [
            "status" => 'success',
            "message" => $message,
        ];
    }

    public function destroy($id)
    {
        if (!User::find(auth()->id())->can('delete_attendance')) {
            return abort(401);
        }

        $attendance = Attendance::findOrFail($id);
        $attendance->delete();
        return "success";
    }
}
