<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Carbon\CarbonPeriod;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\CompanySetting;

class MyPayrollController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function my_payroll_table(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

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
            'employees' => User::where('id', auth()->id())->get(),
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
