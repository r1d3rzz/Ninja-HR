@props(['title' => "Ninja HR"])

<div class="app-bar text-center p-3 shadow bg-white">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="d-flex justify-content-between align-items-center fs-5">
                <div type="button">
                    <i class="fa-solid fa-bars" id="show-sidebar"></i>
                </div>
                <div>
                    {{$title}}
                </div>
                <div></div>
            </div>
        </div>
    </div>
</div>
