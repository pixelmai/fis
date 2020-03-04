@extends('layouts.login_temp')

@section('content')
<div class="container pt-3">
  <div class="row justify-content-center py-5">
    <div id="logo"></div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div id="login" class="card">
        <div class="card-header">{{ __('Login') }}</div>

        <div class="card-body">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group row" >
              <div class="col-12">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email Address">

                @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <div class="col-12">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <div class="col-12">
                <div class="d-flex justify-content-between">
                  <div>
                    
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                      <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                      </label>
                    </div>
                  </div>

                  <div>
                 
                    @if (Route::has('password.request'))
                      <a href="{{ route('password.request') }}">
                        {{ __('Forgot Password?') }}
                      </a>
                    @endif
                   
                  </div>
                </div>
              </div>

            </div>

            <div class="form-group row mb-0">
              <div class="col-md-12">
                <button type="submit" class="btn btn-block btn-primary">
                  Sign In
                </button>

              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
