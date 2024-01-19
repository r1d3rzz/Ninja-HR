<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\CompanySetting;

class PayrollController extends Controller
{
    public function index()
    {
        return view('payroll.index');
    }

    public function payroll_table(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $employee_name = $request->employee_name;

        $startOfMonth = $year . '-' . $month . '-01';
        $endofMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d');

        $firstDayOfMonth = Carbon::create($year, $month, 1);
        $lastDayofMonth = $firstDayOfMonth->copy()->endOfMonth();

        $weekdayCount = 0;

        $currentDay = $firstDayOfMonth->copy();

        //calculate weekdays in a Month
        while ($currentDay->lte($lastDayofMonth)) {
            if ($currentDay->isWeekday()) {
                $weekdayCount++;
            }
            $currentDay->addDay();
        } //crd chatGPT

        $daysInMonth = $firstDayOfMonth->daysInMonth;

        return view('components.payroll_table', [
            'periods' => CarbonPeriod::create($startOfMonth, $endofMonth),
            'employees' => User::orderBy('employee_id')->where('name', 'like', '%' . $employee_name . '%')->get(),
            'attendances' => Attendance::whereMonth('date', $month)->whereYear('date', $year)->get(),
            'company_setting' => CompanySetting::findOrFail(1),
            'daysInMonth' => $daysInMonth,
            'workingDay' => $weekdayCount,
            'weekenddayCount' => $daysInMonth - $weekdayCount,
            'month' => $month,
            'year' => $year,
        ])->render();
    }
}
