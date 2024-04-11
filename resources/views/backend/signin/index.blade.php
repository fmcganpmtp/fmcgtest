@extends('backend/layout/auth')
@section('body')
<div class="flex-fill d-flex flex-column justify-content-center py-4">
    <div class="container-tight py-6">

    <form method="post" action="{{ route('signin') }}" class="card card-md">
        @csrf
        <div class="card-body">

        <div class="row">
            <div class="col-12 mb-3 text-center">
                <img src="{{ asset('favicons/auth-icon.png') }}" height="45" alt="App Logo"/>
            </div>
        </div>

        <div class="form-group mb-3">
            <label class="form-label">{{ __('Email / Mobile') }} </label>
            <div>
                <input type="text" required name="email" placeholder="Enter Email / Mobile" class="form-control" autofocus tabindex="1">
            </div>
            @error('email')
            <div class="invalid-feedback d-block" role="alert">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label class="form-label">{{ __('Password') }}
                {{-- <span class="form-label-description">
                    <a href="{{ route('password.reset') }}" tabindex="5">I forgot password</a>
                </span> --}}
            </label>
            <div class="input-group input-group-flat">
                <input type="password" required name="password" placeholder="Enter password" class="form-control" tabindex="2">
            </div>
            @error('password')
            <div class="invalid-feedback d-block" role="alert">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="mb-2">
            <label class="form-check">
                <input type="checkbox" id="remember" class="form-check-input" name="remember"  {{ old('remember') ? 'checked' : '' }} tabindex="3">
                <span class="form-check-label">Remember me on this device</span>
            </label>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100" tabindex="4">Sign in</button>
        </div>
        </div>
    </form>
    </div>
</div>
@endsection
