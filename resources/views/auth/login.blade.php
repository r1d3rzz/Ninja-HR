@extends('layouts.app_plain')

@section("title","Login")

@section('content')
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

                        <div data-mdb-input-init class="form-outline mb-4">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label class="form-label" for="form2Example1">Email address</label>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div data-mdb-input-init class="form-outline mb-4">
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">
                            <label class="form-label" for="form2Example2">Password</label>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>



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
@endsection