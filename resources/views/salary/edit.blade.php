<x-layout>
    <x-slot name='title'>
        Salary | Edit
    </x-slot>

    <x-slot name="style">
        <style>
            /* Select2 css */
            @import "https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.min.css";
        </style>
    </x-slot>

    <div class="container p-2">
        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                <div class="card card-body">
                    <form action="{{route('salaries.update',$salary->id)}}" method="POST" id="salaries">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <!--Simple Select with Search-->
                            <div class="form-group">
                                <select class="select-with-search form-select" name="user_id">
                                    <option disabled selected>-- Select Employee --</option>
                                    @foreach ($employees as $employee)
                                        <option @selected($employee->id == $salary->user_id) value="{{$employee->id}}">{{$employee->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <!--Simple Select with Search-->
                            <div class="form-group">
                                <select class="select-with-search form-select" name="month">
                                    <option disabled selected>-- Select Month --</option>
                                        <option value="01" @selected($salary->month == '01')>Jan</option>
                                        <option value="02" @selected($salary->month == '02')>Feb</option>
                                        <option value="03" @selected($salary->month == '03')>Mar</option>
                                        <option value="04" @selected($salary->month == '04')>Apr</option>
                                        <option value="05" @selected($salary->month == '05')>May</option>
                                        <option value="06" @selected($salary->month == '06')>Jun</option>
                                        <option value="07" @selected($salary->month == '07')>Jul</option>
                                        <option value="08" @selected($salary->month == '08')>Aug</option>
                                        <option value="09" @selected($salary->month == '09')>Sep</option>
                                        <option value="10" @selected($salary->month == '10')>Oct</option>
                                        <option value="11" @selected($salary->month == '11')>Nov</option>
                                        <option value="12" @selected($salary->month == '12')>Dec</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <!--Simple Select with Search-->
                            <div class="form-group">
                                <select class="select-with-search form-select" name="year">
                                    <option disabled selected>-- Select Year --</option>
                                    @foreach (range(1,8) as $year)
                                        <option @if($salary->year == now()->addYear(4)->subYear($year)->format('Y')) selected @endif value="{{now()->addYear(4)->subYear($year)->format('Y')}}">{{now()->addYear(4)->subYear($year)->format('Y')}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <x-form.input name="amount" type="number" value="{{$salary->amount}}"/>

                        <button class="btn btn-primary">Update Salary</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <!-- Select2 js-->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.full.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $(".select-with-search").select2({
                    theme: "bootstrap"
                });
            });
        </script>

        {!! JsValidator::formRequest('App\Http\Requests\UpdateSalary', '#salaries'); !!}
    </x-slot>
</x-layout>
