@extends('layouts.template')
@section('title')
FMCG | LOGIN
@endsection
@section('content')
<div class="bg-light min-vh-100 d-flex flex-row align-items-center login-scr">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 ">
        <div class="loginC align-middle">
          <div class="row">
            <div class="col-lg-6 col-12 ">
              <div class="log-left ">
              
            <div class="log-left-content">
              <div class="log-logo"><img src="{{URL::asset('/images/footer-logo.png')}}"></div>
              	<h1>Welcome Back !</h1>
              </div>
              
              </div>
            </div>
            <div class="col-lg-6 col-12">
              <div class="log-right">
              
              <h2>Sign In</h2>
              
            
                 
                  <div class="card-body">
                    @isset($url)
                    <form method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
                    @else
                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    @endisset
                        @csrf

                        <div class="form-group">
                    <label>Email Address</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"  required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>

                 <div class="form-group">
                    <label>Password</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                </div>

                        

                        <div class="frg-pw"><a href="{{ route('forget.password.get' ) }}">Forgot password?</a></div>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                
                            
                    </form>
                </div>
                  <div class="n-reg">Don't have an account? <a href="{{route('user-register')}}">sign up now</a></div>
                  
                  
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
