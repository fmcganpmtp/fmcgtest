@extends('backend/layout/app', ['sidebar' => false])
@section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                <li class="breadcrumb-item"><a href="{{ route('order') }}">{{ __('Order') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:">{{ __('New') }}</a></li>
            </ol>
        </div>
        <h2 class="page-title" act-on="click">{{ __('New Order') }}</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="d-flex">
            @if(hasPermission('order'))
            <a href="{{ route('order') }}" class="btn btn-primary">
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
                <form act-on="submit" act-request="{{ route('order.store') }}">
 
                <div class="row">
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Geo Location') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_geo_location"  required   class="form-control">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Latitude') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_latitude"  required   class="form-control">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Longitude') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_longitude"  required   class="form-control">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Address') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_address"  required   class="form-control">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Location') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_location"  required   class="form-control">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Phone') }} </label>
                                <div>
                                    <input type="text" name="delivery_phone"   class="form-control">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Type') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_type"  required   class="form-control">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Weight') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_weight"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Distance') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_distance"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Charge') }} </label>
                                <div>
                                    <input type="text" name="delivery_charge"   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Discount Code') }} </label>
                                <div>
                                    <textarea class="form-control"  name="discount_code" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Discount Amount') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="discount_amount"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Total Amount') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="total_amount"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Final Amount') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="final_amount"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Commission Amount') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="commission_amount"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Note') }} </label>
                                <div>
                                    <textarea class="form-control"  name="note" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
 
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Status') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="status"  required   class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('User Name') }} <span class="text-danger">*</span></label>
                                <div>
                                    <select name="assign_user_id" required class="form-select select2">
                                        <option disabled selected value=""></option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>                                           
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('User Name') }} <span class="text-danger">*</span></label>
                                <div>
                                    <select name="user_id" required class="form-select select2">
                                        <option disabled selected value=""></option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>                                           
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Vendor Name') }} <span class="text-danger">*</span></label>
                                <div>
                                    <select name="vendor_id" required class="form-select select2">
                                        <option disabled selected value=""></option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                        @endforeach
                                    </select>                                           
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
                                    Save
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
