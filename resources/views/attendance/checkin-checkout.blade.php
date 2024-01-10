<x-layout-plain>
    <x-slot name="title">
        Checkin | Checkout
    </x-slot>

    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh">
            <div class="col-lg-6">
                <div class="card card-body text-center">
                    <div>
                        <h1 class="h4">QR Code</h1>
                        <img
                            src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(250)->generate('Make me into an QrCode!')) !!} ">
                        <p>Please Scan QR Code for Check In or Checkout</p>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <h1 class="h4">Pin Code</h1>
                        <input type="text" name="mycode" id="pincode">
                        <p class="mt-3">Please Enter Pin Code for Check In or Checkout</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="module">
            $(function(){
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
                $('#pincode').pincodeInput({inputs:6,complete:function(value, e, errorElement){
                    $.ajax({
                        "url": "/checkin",
                        "type": "POST",
                        "data": {pin_code:value},
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

                    $(".pincode-input-container .pincode-input-text").val("");
                    $(".pincode-input-text").first().focus();
                }});

                $(".pincode-input-text").first().focus();
            })
        </script>
    </x-slot>
</x-layout-plain>