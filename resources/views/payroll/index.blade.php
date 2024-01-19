<x-layout>
    <x-slot name="title">
        Payroll
    </x-slot>

    <div class="container-fluid employeesTable-container p-2">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="mb-3">
                          <form>
                            <div class="row">
                                <div class="col-md-3 mb-2 mb-lg-0">
                                    <input type="text" id="employee_name" placeholder="Employee Name" class="form-control">
                                </div>
                                <div class="col-md-3 mb-2 mb-lg-0">
                                    <select id="month" class="form-select">
                                        <option value="" disabled selected class="text-center">-- Select Month --</option>
                                        <option value="01" @if(now()->format('m') == '01') selected @endif>Jan</option>
                                        <option value="02" @if(now()->format('m') == '02') selected @endif>Feb</option>
                                        <option value="03" @if(now()->format('m') == '03') selected @endif>Mar</option>
                                        <option value="04" @if(now()->format('m') == '04') selected @endif>Apr</option>
                                        <option value="05" @if(now()->format('m') == '05') selected @endif>May</option>
                                        <option value="06" @if(now()->format('m') == '06') selected @endif>Jun</option>
                                        <option value="07" @if(now()->format('m') == '07') selected @endif>Jul</option>
                                        <option value="08" @if(now()->format('m') == '08') selected @endif>Aug</option>
                                        <option value="09" @if(now()->format('m') == '09') selected @endif>Sep</option>
                                        <option value="10" @if(now()->format('m') == '10') selected @endif>Oct</option>
                                        <option value="11" @if(now()->format('m') == '11') selected @endif>Nov</option>
                                        <option value="12" @if(now()->format('m') == '12') selected @endif>Dec</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-2 mb-lg-0">
                                    <select id="year" class="form-select">
                                        <option value="" disabled selected class="text-center">-- Select Year --</option>

                                        @for ($i = 0; $i < 5; $i++)
                                        <option @if(now()->format('Y') == now()->subYears($i)->format('Y')) selected @endif value="{{now()->subYears($i)->format('Y')}}">{{now()->subYears($i)->format('Y')}}</option>
                                        @endfor

                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-primary float-end float-lg-start w-100" id="searchBtn">Search</button>
                                </div>
                               </div>
                          </form>
                        </div>
                        <div class="payroll_table"></div>
                    </div>
                </div>
            </div>
        </div>

        <x-slot name="script">
            <script type="text/javascript">
                $(document).ready(function(){
                    function getPayrollTable()
                    {
                        var month = $('#month').val();
                        var year = $('#year').val();
                        var employee_name = $('#employee_name').val();

                        $.ajax({
                            url: `/payroll_table?month=${month}&year=${year}&employee_name=${employee_name}`,
                            type: 'GET',
                            success: function(res){
                                $('.payroll_table').html(res);
                            },
                        });
                    }

                    $('#searchBtn').on('click',function(e){
                        e.preventDefault();
                        getPayrollTable();
                    });

                    getPayrollTable();
                });
            </script>
        </x-slot>
    </div>


</x-layout>
