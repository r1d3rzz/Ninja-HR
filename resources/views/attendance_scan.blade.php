<x-layout>
    <x-slot name="title">
        Attendance QR Scan
    </x-slot>

    <div class="container p-2">
        <div class="row justify-content-center">
            <div class="col-md-11 mb-5">
                <div class="card mb-3">
                    <div class="card-body text-center p-5">
                        <div>
                            <img src="{{asset('image/qr-code-scan.png')}}" alt="sample_qr" class="img-fluid"
                                width="300px">
                        </div>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#qrScanner">
                            Open Scanner
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="qrScanner" tabindex="-1" aria-labelledby="qrScannerLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="qrScannerLabel">Scan Attendance QR</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <video width="100%" id="qr_scan"></video>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger w-100"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-body mb-3">
                    <div class="mb-3">
                      <form>
                        <div class="row">

                            <div class="col-md-4 mb-2 mb-lg-0">
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
                            <div class="col-md-4 mb-2 mb-lg-0">
                                <select id="year" class="form-select">
                                    <option value="" disabled selected class="text-center">-- Select Year --</option>

                                    @for ($i = 0; $i < 5; $i++)
                                    <option @if(now()->format('Y') == now()->subYears($i)->format('Y')) selected @endif value="{{now()->subYears($i)->format('Y')}}">{{now()->subYears($i)->format('Y')}}</option>
                                    @endfor

                                </select>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-primary float-end float-lg-start w-100" id="searchBtn">Search</button>
                            </div>
                           </div>
                      </form>
                    </div>
                    <div class="attendances_overview_table"></div>
                </div>
                <div class="card p-0">
                    <div class="card-body">
                        <table class="table dbtable-align table-bordered display nowrap" id="attendances" width="100%">
                            <thead>
                                <tr class="text-center">
                                    <th>Employee</th>
                                    <th>Date</th>
                                    <th>Checkin Time</th>
                                    <th>Checkout Time</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script src="{{asset('js/qr_scan/qr-scanner.umd.min.js')}}"></script>
        <script>
            $(function () {
                const qrScannerModal = document.getElementById('qrScanner');
                var videoElem = document.getElementById('qr_scan');
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });

                const qrScanner = new QrScanner(videoElem,function(res){
                    if(res){
                        qrScanner.stop();
                        $('#qrScanner').modal('hide');

                        $.ajax({
                            "url": '/attendance_scan',
                            "type": 'POST',
                            "data": {hash_value:res},
                            "success": function(res){
                                if(res.status == "success"){
                                    Toast.fire({
                                        icon: "success",
                                        title: res.message,
                                    });
                                }else{
                                    Toast.fire({
                                        icon: "error",
                                        title: res.message,
                                    });
                                }
                            }
                        });
                    }
                });

                qrScannerModal.addEventListener('shown.bs.modal', event => {
                    qrScanner.start();
                });

                qrScannerModal.addEventListener('hidden.bs.modal', event => {
                    qrScanner.stop();
                });

                var table = $('#attendances').DataTable({
                    ajax: "{{ route('my-attendances_overview_table.index') }}",
                    columns: [
                        {data: 'employee_name', name: 'employee_name'},
                        {data: 'date', name: 'date'},
                        {data: 'checkin_time', name: 'checkin_time'},
                        {data: 'checkout_time', name: 'checkout_time'},
                    ],
                    order: [[2, 'desc']]
                });

                function getAttendancesOverviewTable()
                {
                    var month = $('#month').val();
                    var year = $('#year').val();
                    var employee_name = $('#employee_name').val();

                    $.ajax({
                        url: `/my-attendances_overview_table?month=${month}&year=${year}`,
                        type: 'GET',
                        success: function(res){
                            $('.attendances_overview_table').html(res);
                        },
                    });

                    table.ajax.url(`/my-attendances_overview_table/all?month=${month}&year=${year}`).load();
                }

                $('#searchBtn').on('click',function(e){
                    e.preventDefault();
                    getAttendancesOverviewTable();
                });

                getAttendancesOverviewTable();

             });
        </script>
    </x-slot>
</x-layout>
