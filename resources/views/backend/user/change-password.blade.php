@extends('backend/layout/app', ['sidebar' => false])
@section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">{{ __('Application') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('Change Password') }}</a></li>
            </ol>
        </div>
        <h2 class="page-title" act-on="click">{{ __('Change Password') }}</h2>
    </div>
</div>
@endsection
@section('body')
<div class="row">
    <div class="col-lg-12">
 
        <div class="card px-2">
            <div class="card-body">
                <form act-on="submit" act-request="{{ route('user.change.password') }}">
 
                <div class="row">
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label>Current Password <span class="text-danger">*</span></label>
                                <div class="form-element">
                                    <input type="password" name="current-password" required class="form-control" autofocus>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label>New Password <span class="text-danger">*</span></label>
                                <div class="form-element">
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                        </div>
 
                    </div>
 
                    <div class="row mb-3">
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-footer mt-3">
                                <button type="reset" class="btn btn-secondary">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary ms-2">
                                Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
