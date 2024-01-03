<x-layout>
    <x-slot name="title">
        Company Setting
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card card-body">
                    <div class="row">
                        <x-company-setting-wrapper class="mb-4">
                            <div class="fs-6 fw-bold">Name</div>
                            <div class="text-muted">{{$setting->name}}</div>
                        </x-company-setting-wrapper>

                        <x-company-setting-wrapper class="mb-4">
                            <div class="fs-6 fw-bold">Email</div>
                            <div class="text-muted">{{$setting->email}}</div>
                        </x-company-setting-wrapper>

                        <x-company-setting-wrapper class=" mb-4">
                            <div class="fs-6 fw-bold">Phone</div>
                            <div class="text-muted">{{$setting->phone}}</div>
                        </x-company-setting-wrapper>

                        <x-company-setting-wrapper class=" mb-4">
                            <div class="fs-6 fw-bold">Address</div>
                            <div class="text-muted">{{$setting->address}}</div>
                        </x-company-setting-wrapper>

                        <x-company-setting-wrapper class=" mb-4">
                            <div class="fs-6 fw-bold">Office Start Time</div>
                            <div class="text-muted">{{$setting->office_start_time}}</div>
                        </x-company-setting-wrapper>

                        <x-company-setting-wrapper class=" mb-4">
                            <div class="fs-6 fw-bold">Office Start Time</div>
                            <div class="text-muted">{{$setting->office_end_time}}</div>
                        </x-company-setting-wrapper>

                        <x-company-setting-wrapper class=" mb-4">
                            <div class="fs-6 fw-bold">Break Start Time</div>
                            <div class="text-muted">{{$setting->break_start_time}}</div>
                        </x-company-setting-wrapper>

                        <x-company-setting-wrapper class=" mb-4">
                            <div class="fs-6 fw-bold">Break End Time</div>
                            <div class="text-muted">{{$setting->break_end_time}}</div>
                        </x-company-setting-wrapper>

                        <a href="{{route('company_settings.edit',1)}}" class="btn btn-sm btn-warning">Edit Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function () {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                    });

                @if (session('updated'))
                    Toast.fire({
                        icon: "success",
                        title: "{{ session('updated') }}"
                    });
                @endif
             });
        </script>
    </x-slot>

</x-layout>
