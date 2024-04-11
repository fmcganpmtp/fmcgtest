@extends('layouts.template_mobile')
@section('title','FMCG | Welcome')
@section('content')
<div class="bg-light min-vh-100 d-flex flex-row align-items-center login-scr">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 ">
        <div class="loginC align-middle no-act-c">
          <div class="row">
            <div class="col-lg-6 col-12 ">
              <div class="log-left ">
              
            <div class="log-left-content">
              <div class="log-logo"><img src="{{URL::asset('images/footer-logo.png')}}"></div>
              	<h1>Welcome !</h1>
              </div>
              
              </div>
            </div>
            <div class="col-lg-6 col-12">
              <div class="log-right">
              
              <?php
              $email=Request::get('email');
              $token=Request::get('token');
              //$user=\App\User::where(['email' => $email])->pluck('name')->first();
              //$user=\App\User::where(['email' => $email])->get();
              $token_exists= \App\User::where("token_number", $token)->where("email", $email)->exists();
              if ($token_exists) {
              ?>
              Welcome to FMCG Land
              <h2>Add Password</h2>
              <form action="{{ route('savePasswordForm') }}" method="POST">
                          @csrf
                          <input type="hidden" name="email" value={{ Request::get('email') }} >
                          <div class="form-group row">
                              <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password" class="form-control pr-password" autocomplete="off" name="password" required >
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                              <div class="col-md-6">
                                  <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required >
                                  @if ($errors->has('password_confirmation'))
                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  Add Password
                              </button>
                          </div>
                      </form>
              <?php } else { ?>

<div class="no-active">
<h6><b>Sorry!</b><br/> No active invite for this user.</h6>
</div>


<?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="{{ asset('/css/jquery.passwordRequirements.css')}}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('js/jquery.passwordRequirements.js')}}"></script>
<script src="{{ asset('js/jquery.passwordRequirements.min.js')}}"></script>
<script>
      var $ = jQuery;
      (function($) {
        $(document).ready( function () {
            $(".pr-password").passwordRequirements({});
      });
      })(jQuery);    
    </script>
@endsection
