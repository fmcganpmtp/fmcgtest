@extends('backend/layout/app', ['sidebar' => false])
@section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                <li class="breadcrumb-item"><a href="{{ route('product') }}">{{ __('Users') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:">{{ __('Address') }}</a></li>
            </ol>
        </div>
        <h2 class="page-title" act-on="click">{{ __('Address') }}</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="d-flex">
            @if(hasPermission('user'))
            <a href="{{ route('user') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="9" y1="6" x2="20" y2="6" /><line x1="9" y1="12" x2="20" y2="12" /><line x1="9" y1="18" x2="20" y2="18" /><line x1="5" y1="6" x2="5" y2="6.01" /><line x1="5" y1="12" x2="5" y2="12.01" /><line x1="5" y1="18" x2="5" y2="18.01" /></svg>
                View All
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
@section('body')
<div class="row">
    <div class="col-lg-12">

        <div class="card px-2">
            <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                        <b>{{ __('Name') }} :</b>
                                        {{$user->name}}
                                    </div>

                                    <div class="form-group">
                                    <b>{{ __('Mobile') }} :</b>
                                    {{$user->mobile}}
                                </div>
                                <div class="form-group">
                                    <b>{{ __('Email') }} :</b>
                                    {{$user->email}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                     <div class="row">
                        @foreach($getAddress as $address)
                        <div class="col-lg-3 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Address') }}  : </label>
                                {{$address->geo_location}},
                                {{$address->address}}
                            </div>

                            <div class="form-group">
                                <label>{{ __('Location') }}  : </label>
                                {{$address->location}}
                            </div>
                            <div class="form-group">
                                <label>{{ __('Phone') }}  : </label>
                                {{$address->phone}}
                            </div>

                        </div>

                        @endforeach
                    </div>

                </div>

                  <!--   <div class="row mb-3">
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-footer mt-3">
                                <button type="reset" class="btn btn-secondary">
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary ms-2">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div> -->

            </div>
        </div>
    </div>
</div>
@endsection
