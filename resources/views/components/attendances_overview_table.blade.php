<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr class="align-middle">
                <th>Employee</th>
                @foreach ($periods as $period)
                <th class="@if($period->format('D') == 'Sat' || $period->format('D') == 'Sun') text-bg-info @endif text-center">
                    {{$period->format('d')}}
                    {{$period->format('D')}}
                </th>
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

                if($attendance){
                    if($attendance->checkin_time <= $office_start_time){
                        $checkin_icon="<i class='fa-solid fa-check-circle fs-5 text-success'></i>" ;
                    }else if($attendance->checkin_time > $office_start_time && $attendance->checkin_time <= $break_start_time){
                        $checkin_icon="<i class='fa-solid fa-check-circle fs-5 text-warning'></i>" ;
                    }else{
                        $checkin_icon="<i class='fa-solid fa-times-circle fs-5 text-danger'></i>" ;
                    }

                    if($attendance->checkout_time >= $office_end_time){
                        $checkout_icon="<i class='fa-solid fa-check-circle fs-5 text-success'></i>" ;
                    }else if($attendance->checkout_time <= $office_end_time && $attendance->checkout_time > $break_end_time){
                        $checkout_icon="<i class='fa-solid fa-check-circle fs-5 text-warning'></i>" ;
                    }else{
                        $checkout_icon="<i class='fa-solid fa-times-circle fs-5 text-danger'></i>" ;
                    }
                };
                @endphp

                <td @if($period->format('D') == 'Sat' || $period->format('D') == 'Sun') class="text-bg-info" @endif>
                    {!!$checkin_icon!!}
                    {!!$checkout_icon!!}
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
