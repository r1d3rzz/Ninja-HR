<x-layout-plain>
    <x-slot name="title">
        Login
    </x-slot>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <div class="mb-2 text-center">
                    <img src="{{asset('image/logo.png')}}" width="70px" alt="Ninja Hr">
                </div>
                <div class="card">
                    <div class="card-header text-center pb-0">
                        <h4>Login</h4>
                        <p class="text-muted">Please fill login form</p>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <x-form.input name="phone" type="tel" />

                            <x-form.input name="password" type="password" />

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{
                                    old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label user-select-none" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>

                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-plain>