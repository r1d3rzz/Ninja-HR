<x-layout>
    <x-slot name="title">
        Attendance QR Scan
    </x-slot>

    <div class="container p-2">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
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
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="qrScannerLabel">Scan Attendance QR</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <video width="100%" height="400px" id="qr_scan"></video>
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

             });
        </script>
    </x-slot>
</x-layout>