<div class="table-responsive">
    <table class="table table-bordered text-center">
        <thead>
            <tr class="align-middle">
                <th>Employee</th>
                <th>Role</th>
                <th>Days in Month</th>
                <th>Working Days</th>
                <th>Off Days</th>
                <th>Attendance Days</th>
                <th>Leave</th>
                <th>Per Day (MMK)</th>
                <th>Total (MMK)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            @php
                $attendanceCount = 0;
                $salary = collect($employee->salaries)->where('month',$month)->where('year',$year)->first();
                $perDay = $salary ? $salary->amount / $workingDay : 0;
            @endphp
            <tr>
                <td class="text-start">{{$employee->name}}</td>
                <td>
                    @foreach ($employee->roles as $role)
                        <div>{{$role->name}}</div>
                    @endforeach
                </td>
                <td>{{$daysInMonth}}</td>
                <td>{{$workingDay}}</td>
                <td>{{$weekenddayCount}}</td>
                @foreach ($periods as $period)
                @php
                $office_start_time = $period->format('Y-m-d').' '.$company_setting->office_start_time;
                $office_end_time = $period->format('Y-m-d').' '.$company_setting->office_end_time;
                $break_start_time = $period->format('Y-m-d').' '.$company_setting->break_start_time;
                $break_end_time = $period->format('Y-m-d').' '.$company_setting->break_end_time;

                $attendance = collect($attendances)->where('user_id',$employee->id)->where('date',$period->format('Y-m-d'))->first();

                if($attendance){
                    if($attendance->checkin_time <= $office_start_time){
                        $attendanceCount += 0.5;
                    }else if($attendance->checkin_time > $office_start_time && $attendance->checkin_time < $break_start_time){
                        $attendanceCount += 0.5;
                    }else{
                        $attendanceCount += 0;
                    }

                    if($attendance->checkout_time >= $office_end_time){
                        $attendanceCount += 0.5;
                    }else if($attendance->checkout_time <= $office_end_time && $attendance->checkout_time > $break_end_time){
                        $attendanceCount += 0.5;
                    }else{
                        $attendanceCount += 0;
                    }
                };
                @endphp
            @endforeach
            @php
                $leaveCount = $workingDay - $attendanceCount;
                $total = $perDay * $attendanceCount;
            @endphp

                <td>{{$attendanceCount}}</td>
                <td>{{$leaveCount}}</td>
                <td>{{number_format($perDay)}}</td>
                <td>{{number_format($total)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
