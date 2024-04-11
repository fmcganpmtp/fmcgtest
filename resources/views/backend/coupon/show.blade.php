@extends('backend/layout/app', ['sidebar' => false])
@section('header')
    <div class="row align-items-center">
        <div class="col-md-4 col-sm-12">
            <div class="mb-1">
                <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('coupon') }}">{{ __('coupon') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('show') }}</a></li>
                </ol>
            </div>
            <h2 class="page-title" act-on="click">{{ __('Coupon Details') }}</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
                @if (hasPermission('coupon'))
                    <a href="{{ route('coupon') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="9" y1="6" x2="20" y2="6" />
                            <line x1="9" y1="12" x2="20" y2="12" />
                            <line x1="9" y1="18" x2="20" y2="18" />
                            <line x1="5" y1="6" x2="5" y2="6.01" />
                            <line x1="5" y1="12" x2="5" y2="12.01" />
                            <line x1="5" y1="18" x2="5" y2="18.01" />
                        </svg>
                        {{ __('View All') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('body')
    <div class="modal-body col-md-6 vendor-show-input">
        <input type="hidden" name="_method" value="patch">
        <div class="row">
            <div class="form-group">
                <label><span>{{ __('Title') }}</span> : {{ $coupon->title }}</label>
            </div>
            <div class="form-group">
                <label><span>{{ __('Vendor') }}</span> : {{ $coupon->vendor_name }}</label>
            </div>
            <div class="form-group">
                <label><span>{{ __('Description') }}</span> : {{ $coupon->description }}</label>
            </div>
            <div class="form-group">
                <label><span>{{ __('Tems&Conditions') }}</span> : {{ $coupon->tc }}</label>
            </div>
            <div class="form-group">
                <label><span>{{ __('Code') }}</span> : {{ $coupon->code }}</label>
            </div>
            <div class="form-group">
                <label><span>{{ __('Min Cart Amount') }}</span> : {{ $coupon->min_cart_amount }}</label>
            </div>
            <div class="form-group">
                <label><span>{{ __('Max Cart Amount') }}</span> : {{ $coupon->max_cart_amount }}</label>
            </div>
            <div class="form-group">
                <label><span>{{ __('On Which Order') }}</span> : {{ $coupon->on_which_order }}</label>
            </div>
            <div class="form-group">
                <label><span>{{ __('Discount Amount') }}</span> : {{ $coupon->discount_amount }}</label>
            </div>
            <div class="form-group">
                <label><span>{{ __('Status') }}</span> : {{ $coupon->status }}</label>
            </div>

        </div>
    </div>
@endsection
