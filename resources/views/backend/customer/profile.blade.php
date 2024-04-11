@extends('backend/layout/app', ['sidebar' => false])
@section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">{{ __('Application') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('Manage Profile') }}</a></li>
            </ol>
        </div>
        <h2 class="page-title" act-on="click">{{ __('Manage Profile') }}</h2>
    </div>
</div>
@endsection
@section('body')
<div class="row">
    <div class="col-lg-12">
 
        <div class="card px-2">
            <div class="card-body">
                <form act-on="submit" act-request="{{ route('user.update.profile') }}">
 
                <div class="row">
 
                        <div class="col-lg-4 col-sm-12">
                          <div class="form-group">
                              <label>Name <span class="text-danger">*</span></label>
                              <div class="form-element">
                                  <input type="text" name="name" value="{{ $user->name }}" required class="form-control" autofocus>
                              </div>
                          </div>
                        </div>

                        <div class="col-lg-4 col-sm-12">
                          <div class="form-group">
                              <label>Email (optional)</label>
                              <div class="form-element">
                                  <input type="text" name="email"  value="{{ $user->email }}"  class="form-control">
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
