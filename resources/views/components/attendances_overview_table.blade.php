<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee</th>
                @foreach ($periods as $period)
                <th>{{$period->format('d')}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td>{{$employee->name}}</td>
                @foreach ($periods as $period)
                @php
                $office_start_time = $period->format('Y-m-d').' '.$company_setting->office_start_time;
                $office_end_time = $period->format('Y-m-d').' '.$company_setting->office_end_time;
                $break_start_time = $period->format('Y-m-d').' '.$company_setting->break_start_time;
                $break_end_time = $period->format('Y-m-d').' '.$company_setting->break_end_time;

                $checkin_icon = '';
                $checkout_icon = '';
                $attendance = collect($attendances)->where('user_id',$employee->id)->where('date',$period->format('Y-m-d'))->first();

                if(!$attendance) return false;

                if($attendance->checkin_time <= $office_start_time){
                    $checkin_icon="<i class='fa-solid fa-check-circle text-success'></i>" ;
                }else if($attendance->checkin_time > $office_start_time && $attendance->checkin_time <= $break_start_time){
                    $checkin_icon="<i class='fa-solid fa-check-circle text-warning'></i>" ;
                }else{
                    $checkin_icon="<i class='fa-solid fa-times-circle text-danger'></i>" ;
                }

                if($attendance->checkout_time >= $office_end_time){
                    $checkout_icon="<i class='fa-solid fa-check-circle text-success'></i>" ;
                }else if($attendance->checkout_time <= $office_end_time && $attendance->checkout_time > $break_end_time){
                    $checkout_icon="<i class='fa-solid fa-check-circle text-warning'></i>" ;
                }else{
                    $checkout_icon="<i class='fa-solid fa-times-circle text-danger'></i>" ;
                }
                @endphp

                <td>
                    {!!$checkin_icon!!}
                    {!!$checkout_icon!!}
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
