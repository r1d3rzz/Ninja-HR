@props(['title' => "Ninja HR"])

<div class="app-bar text-center p-3 shadow bg-white">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="d-flex justify-content-between align-items-center fs-5">
                <div type="button">
                    @if (request()->is("/"))
                    <i class="fa-solid fa-bars" id="show-sidebar"></i>
                    @else
                    <i class="fa-solid fa-angle-left" id="back-btn"></i>
                    @endif
                </div>
                <div>
                    {{$title}}
                </div>
                <div></div>
            </div>
        </div>
    </div>
</div>
