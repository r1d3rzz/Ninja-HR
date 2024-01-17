<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use Yajra\DataTables\Facades\DataTables;

class MyAttendanceController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {

        if (\request()->ajax()) {
            $data = Attendance::with('employee')->where('user_id', auth()->id())->orderBy('created_at', 'desc');

            if (request()->month) {
                $data = $data->whereMonth('date', request()->month);
            }

            if (request()->year) {
                $data = $data->whereYear('date', request()->year);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->addColumn('employee_name', function ($row) {
                    return $row->employee ? $row->employee->name : '-';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('attendance_scan');
    }

    public function my_attendances_overview_table(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        $startOfMonth = $year . '-' . $month . '-01';
        $endofMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');

        return view('components.attendances_overview_table', [
            'periods' => CarbonPeriod::create($startOfMonth, $endofMonth),
            'employees' => User::orderBy('employee_id')->where('id', auth()->id())->get(),
            'attendances' => Attendance::whereMonth('date', $month)->whereYear('date', $year)->get(),
            'company_setting' => CompanySetting::findOrFail(1),
        ])->render();
    }
}
