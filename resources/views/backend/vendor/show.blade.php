@extends('backend/layout/app', ['sidebar' => false])
@section('header')
    <div class="row align-items-center">
        <div class="col-md-4 col-sm-12">
            <div class="mb-1">
                <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vendor') }}">{{ __('Vendor') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('show') }}</a></li>
                </ol>
            </div>
            <h2 class="page-title" act-on="click">{{ __('Vendor Details') }}</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
                @if (hasPermission('vendor'))
                    <a href="{{ route('vendor') }}" class="btn btn-primary">
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
                    @if($vendor->is_grofirst_vendor=='true')

                        <a href="javascript:void(0)"  class="btn btn-primary ms-2 button-make-vendor" act-confirm="You want to remove this vendor from grofirst vendor list !" data-id="{{$vendor->id}}" data-type="{{$vendor->is_grofirst_vendor}}"  title="Make Grofirst Vendor">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" version="1.1" id="Capa_1" class="icon" width="16" height="16" viewBox="0 0 436.38 436.381" xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M218.19,232c54.735,0,99.107-51.936,99.107-116c0-88.842-44.371-116-99.107-116c-54.736,0-99.107,27.158-99.107,116    C119.083,180.064,163.455,232,218.19,232z"/>
                                    <path d="M432.47,408.266l-50-112.636c-1.838-4.142-5.027-7.534-9.045-9.626l-79.62-41.445c-4.809-2.504-10.423-2.947-15.564-1.231    c-5.141,1.715-9.364,5.442-11.707,10.329L232.7,324.266l4.261-38.408c0.133-1.201-0.174-2.412-0.865-3.405l-13.8-19.839    c-0.048-0.068-0.104-0.131-0.154-0.195l11.935-9.061c1.028-0.781,1.633-1.998,1.633-3.291c0-4.834-3.935-8.769-8.77-8.769h-17.498    c-4.835,0-8.769,3.935-8.769,8.769c0,1.293,0.604,2.51,1.633,3.291l11.934,9.061c-0.051,0.064-0.106,0.127-0.154,0.195    l-13.8,19.839c-0.691,0.993-0.999,2.204-0.865,3.405l4.26,38.408l-33.834-70.609c-2.342-4.887-6.566-8.614-11.707-10.329    c-5.14-1.716-10.757-1.271-15.564,1.231l-79.62,41.445c-4.018,2.092-7.207,5.484-9.045,9.626l-50,112.636    c-2.746,6.188-2.177,13.342,1.512,19.018c3.689,5.674,9.999,9.098,16.768,9.098h392c6.769,0,13.078-3.424,16.768-9.1    C434.648,421.607,435.216,414.453,432.47,408.266z"/>
                                </g>
                            </g>
                            </svg> {{ __("Remove From Grofirst Vendors") }}
                        </a>
                    @else
                        <a href="javascript:void(0)" class="btn btn-primary ms-2 button-make-vendor" act-confirm="You want to make this vendor as grofirst vendor !" data-id="{{$vendor->id}}" data-type="{{$vendor->is_grofirst_vendor}}"  title="Make Grofirst Vendor">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464H398.7c-8.9-63.3-63.3-112-129-112H178.3c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3z"/></svg> {{ __("Add to Grofirst Vendors") }}
                        </a>
                     @endif

                @endif
            </div>
        </div>
    </div>
@endsection
@section('body')
    {{-- <div class="row"> --}}
    <div class="col-lg-12  vendor-show-input">

        <div class="card px-2">
            <div class="card-body">
                <div class="row">

                    <div class="col-lg-12 col-sm-12">
                        <div class="row">
                            <div class="col-lg-2 col-sm-6">

                                <div class="form-group">
                                    <label><b class="d-block mb-2">{{ __('Logo') }} :</b>
                                        @if ($vendor->logo == '')
                                            <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="img-thumbnail custom-file-preview" width="100%" height="150px" />
                                        @else
                                            <img src="{{ asset('uploads/' . $vendor->logo) }}" class="img-thumbnail custom-file-preview" width="150;" height="150px" />
                                        @endif
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-6">
                                <div class="form-group">
                                    <label><b class="d-block mb-2">{{ __('Image') }} :</b>
                                        @if ($vendor->image == '')
                                            <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="img-thumbnail custom-file-preview" width="150px;" height="150px" />
                                        @else
                                            <img src="{{ asset('uploads/' . $vendor->image) }}" class="img-thumbnail custom-file-preview" width="150" height="150px" />
                                        @endif
                                </div>
                            </div>

                            <div class="col-lg-2 col-sm-6">
                                <div class="form-group">
                                    <label><b class="d-block mb-2">{{ __('Thumbnail') }} :</b></label>
                                    <form method="post" id="form-update-vendor-main-logo" act-on="submit" act-request="{{ route('vendor.mainlogo.update', ['vendor' => $vendor->id]) }}">

                                        <div>
                                            <div class="custom-file d-flex">
                                                <input type="file" id="update-vendor-main-logo" class="custom-file-input" name="main-logo" hidden accept="image/*">

                                                <div class="preview">
                                                    @if ($vendor->main_logo == '')
                                                        <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                    @else
                                                        <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $vendor->main_logo) }}" class="custom-file-preview" />
                                                    @endif

                                                </div>
                                                <svg style="position: absolute;z-index:9;right:0;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                                <label class="custom-file-label" for="update-vendor-main-logo">Choose file</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12 mt-3 pb-1">

                                            <div class="form-group">

                                                <button type="submit" disabled="disabled" class="btn btn-primary waves-effect waves-light mr-2 px-3">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="col-lg-4 col-sm-12 mt-3 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Vendor Name') }}</span> : {{ $vendor->name }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 mt-3 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Store Identification Code') }}</span> : {{ $vendor->store_identification_code }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 mt-3 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Gst Number') }}</span> : {{ $vendor->gst_number }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 mt-3 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Fssai Number') }}</span> : {{ $vendor->fssai_number }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Contact Person') }}</span> : {{ $vendor->contact_person }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Phone Number') }}</span> : {{ $vendor->mobile }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Primary Contact Number') }}</span> : {{ $vendor->primary_contact_number }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Secondary Contact Number') }}</span> : {{ $vendor->secondary_contact_number }}</label>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Address') }}</span> : {{ $vendor->address }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Location') }}</span> : {{ $vendor->location }}</label>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Landmark') }}</span> : {{ $vendor->landmark }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('State') }}</span> : {{ $vendor->state }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Pin Code') }}</span> : {{ $vendor->pincode }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Latitude') }}</span> : {{ $vendor->latitude }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Longitude') }}</span> : {{ $vendor->longitude }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Allow Orders Within') }}</span> : {{ $vendor->allow_orders_within }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Maximum Weight to Deliver') }}</span> : {{ $vendor->maximum_weight_to_deliver }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Free Delivery Upto') }}</span> : {{ $vendor->free_delivery_upto }}</label>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Delivery Fee Per KM ') }}</span> : {{ $vendor->delivery_fee_per_km }}</label>
                        </div>
                    </div>


                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Avoid Delivery Fee') }}</span> : {{ $vendor->avoide_delivery_fee }}</label>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Commission Percentage') }}</span> : {{ $vendor->commission_percentage }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12 pb-1">
                        <div class="form-group">
                            <label><span>{{ __('Status') }}</span> : {{ $vendor->status }}</label>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="form-group">
                            <label><span>{{ __('Date of Activation') }}</span> : {{ $vendor->doa }}</label>
                        </div>
                    </div>


                </div>

            </div>
            <form method="POST"act-on="submit" act-request="{{ route('vendor.bank.update', ['vendor' => $vendor->id]) }}"enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12 vendor-show-input">

                    <div class="card px-2">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6 gf-order-delivery-dtls-out">
                                    <div class="gf-order-delivery-dtls">
                                        <h3>Bank Details</h3>


                                        <div class="form-group">
                                            <label for="name">Account Number:</label>
                                            <input type="text" id="account_number" name="account_number" class="form-control" value="{{ $vendor_bank->account_number ?? '' }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">IFSC Code:</label>
                                            <input type="text" id="ifsc_code" name="ifsc_code" class="form-control" value="{{ $vendor_bank->ifsc_code ?? '' }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Bank Name:</label>
                                            <input type="text" id="bank_name" name="bank_name" class="form-control" value="{{ $vendor_bank->bank_name ?? '' }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Account Holder Name:</label>
                                            <input type="text" id="account_holder_name" name="account_holder_name" class="form-control" value="{{ $vendor_bank->account_holder_name ?? '' }}" required>
                                        </div>
                                        {{-- <div class="form-group">
                                            @if (isset($vendor_bank->file) && $vendor_bank->file != '')
                                            <img src="{{ asset('uploads/' . $vendor_bank->file) }}"class="img-fluid custom-file-preview" width="150;" height="150px">
                                            @endif
                                            <label for="name">File:</label>
                                            <input type="file" id="file" name="file" class="form-control" >
                                        </div> --}}

                                    </div>
                                </div>
                                <div class="col-md-6 gf-order-delivery-dtls-out">
                                    <div class="gf-order-delivery-dtls" style="height: 405px;">
                                        <h3>Upload Bank Document </h3>



                                        <div class="custom-file d-flex">
                                            <input type="file" id="update-bank-file" class="custom-file-input" name="file" hidden accept="image/*">

                                            <div class="preview">
                                                @if (isset($vendor_bank->file) && $vendor_bank->file != '')
                                                    <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $vendor_bank->file) }}" class="custom-file-preview" style="width:145px" />
                                                @else
                                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                @endif

                                            </div>
                                            <svg style="position: absolute;z-index:9;right:0;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                            <label class="custom-file-label" for="update-bank-file">Choose file</label>
                                        </div>
                                        @if (hasPermission('vendor.bank.update'))
                                            <button type="submit" class="btn btn-primary mt-4">Update</button>
                                        @endif
                                    </div>


                                </div>




                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-6 gf-order-delivery-dtls-out">
                <div class="gf-order-delivery-dtls" style="height: 505px;">
                    <h3>Revenue Details</h3>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4 mt-3">

                                <div class="form-group">
                                    <label for="name">Total Revnue:</label>
                                    <input type="text" id="total_revenue" name="total_revenue" class="form-control" readonly value="Rs {{ $vendor->total_revenue ?? 0 }}">
                                </div>

                            </div>
                            <div class="col-md-4 mt-3">

                                <div class="form-group">
                                    <label for="name">Total Sale Amount:</label>
                                    <input type="text" id="total_revenue" name="total_revenue" class="form-control" readonly value="Rs {{ $vendor->total_sale_amount ?? 0 }}">
                                </div>

                            </div>
                        </div>

                    </div>



                    <div class="mt-4">

                        <button class="btn btn-primary revenue-filter" type="button" data-type="today">Today</button>
                        <button class="btn btn-primary revenue-filter" type="button" data-type="week">One Week</button>
                        <button class="btn btn-primary revenue-filter" type="button" data-type="month">One Month</button>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">


                                    <label>{{ __('Date From:') }} <span class="text-danger"></span></label>

                                    <input type="date" id="date-from" class="form-control" name="date_from" placeholder="" max="{{ now()->toDateString('Y-m-d') }}" value="{{ request()->get('date_from') != null ? date('Y-m-d', strtotime(request()->get('date_from'))) : '' }}">
                                    <span class="text-danger" id="date-from-error"></span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">

                                    <label>{{ __('Date To:') }} <span class="text-danger"></span></label>
                                    <input type="date" id="date-to" class="form-control" name="date_to" placeholder="" max="{{ now()->toDateString('Y-m-d') }}" value="{{ request()->get('date_to') != null ? date('Y-m-d', strtotime(request()->get('date_to'))) : '' }}">
                                    <span class="text-danger" id="date-to-error"></span>

                                </div>

                            </div>
                            <div class="col-md-3 mt-4">
                                <div class="form-group">

                                    <button class="btn btn-primary mt-2 revenue-filter" type="button" data-type="date-range">Submit</button>
                                </div>
                            </div>
                            <div class="col-md-4 mt-5">
                                <div class="form-group">
                                    <label for="name">Revnue:</label>
                                    <input type="text" id="revenue_filter" name="revenue_filter" class="form-control" readonly value="">
                                </div>
                            </div>
                            <div class="col-md-4 mt-5">
                                <div class="form-group">
                                    <label for="name">Sale Amount:</label>
                                    <input type="text" id="sale_filter" name="sale_filter" class="form-control" readonly value="">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <div class="col-md-12 export-btn text-end">
                            <input type="hidden" name="date_from" id="date-from-filter" value="">
                            <input type="hidden" name="date_to" id="date-to-filter" value="">

                            <button type="button" target="_blank" class="btn btn-primary" name="export" id="export-btn" data-type="all">Export</a>

                        </div>
                        <table act-datatable="{{ route('vendor.orders', ['vendor' => $vendor->id]) }}" search="#search" class="table card-table table-vcenter text-nowrap datatable"id="dtable">
                            <thead>
                                <tr class="bg-transparent">
                                    <th name="id" priority="1" width="8%">SL</th>
                                    <th name="order_id">Order ID</th>
                                    <th name="date_time">Date and Time</th>
                                    <th name="user_name">Customer Name</th>
                                    <th name="user_id">Customer ID</th>
                                    <th name="final_amount">Order Amount</th>
                                    <th name="vendor_name">Vendor Name</th>
                                    <th name="vendor_location">Vendor Location</th>
                                    <th name="status">Status</th>
                                    <th name="payment_status">Payment Status</th>
                                    {{-- <th name="actions" priority="7" width="12%">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody></tbody>


                        </table>

                    </div>
                </div>
            </div>



            {{-- </div> --}}
        @endsection

        @section('script')
            <script>
                $(document).ready(function() {
                    let table = $('#dtable');

                    $('#date-to').on('change', function() {
                        var startDate = new Date($('#date-from').val());
                        var endDate = new Date($('#date-to').val());

                        if (endDate.getTime() < startDate.getTime()) {
                            alert('End date should be greater than Start date.');
                            $('#date-to').val('');
                        }
                    });
                    $('#date-from').on('change', function() {
                        var startDate = new Date($('#date-from').val());
                        var endDate = new Date($('#date-to').val());

                        if (endDate.getTime() < startDate.getTime()) {
                            alert('Start date should be less than End date.');
                            $('#date-from').val('');
                        }
                    });

                    $(document).on('click', '.revenue-filter', function(e) {
                        var type = $(this).attr('data-type');
                        var vendor_id = {{ $vendor->id }}
                        var csrfToken = '{{ csrf_token() }}';
                        var startDate = $('#date-from').val();
                        var endDate = $('#date-to').val();
                        var startDateErrorContainer = $('#date-from-error');
                        var endDateErrorContainer = $('#date-to-error');
                        startDateErrorContainer.text('');
                        endDateErrorContainer.text('');
                        $.get(URL);

                        if (type === 'date-range') {
                            if (!startDate) {
                                startDateErrorContainer.text('Please select a Start Date.');
                            }
                            if (!endDate) {
                                endDateErrorContainer.text('Please select an End Date.');
                            }
                            if (!startDate || !endDate) {
                                return; // Stop further execution
                            }
                        }


                        $.ajax({
                            url: '{{ route('vendor.revenue') }}',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                type: type,
                                vendor_id: vendor_id,
                                date_from: startDate,
                                date_to: endDate
                            },
                            success: function(response) {

                                $('#revenue_filter').val(response.totalRevenue);
                                $('#sale_filter').val(response.totalSale);
                                $('#export-btn').attr('data-type', type);
                                $('#date-from-filter').val(startDate);
                                $('#date-from-filter').val(endDate);

                                table.on('preXhr.dt', function(e, settings, data) {
                                    data.filter = {
                                        type: type,
                                        date_from: startDate,
                                        date_to: endDate,
                                    }
                                });
                                table.DataTable().draw();

                            },
                            error: function(xhr, status, error) {
                                console.log(error);
                            }


                        })
                    });

                    // $(document).on('click', '#export-btn_old', function(e) {

                    //     var type = $(this).attr('data-type');
                    //     var vendor_id = {{ $vendor->id }}
                    //     var csrfToken = '{{ csrf_token() }}';
                    //     // var startDate = $('#date-from').val();
                    //     // var endDate = $('#date-to').val();

                    //     $.ajax({
                    //         url: '{{ route('vendor.order.export') }}',
                    //         method: 'POST',
                    //         headers: {
                    //             'X-CSRF-TOKEN': csrfToken
                    //         },
                    //         data: {
                    //             type: type,
                    //             vendor_id: vendor_id,
                    //             // date_from: startDate,
                    //             // date_to: endDate
                    //         },
                    //         success: function(response) {
                    //             var downloadUrl = response.fileUrl;

                    //             // Create a temporary download link
                    //             var link = document.createElement('a');
                    //             link.href = downloadUrl;
                    //             link.target = '_blank';
                    //             link.download = 'vendor_order_export.xlsx';

                    //             // Append the link to the document and trigger the click event
                    //             document.body.appendChild(link);
                    //             link.click();

                    //             // Remove the link from the document
                    //             document.body.removeChild(link);
                    //         },
                    //         error: function(xhr, status, error) {
                    //             console.log(error);
                    //         }


                    //     })

                    // });
                    $(document).on('click', '#export-btn', function(e) {

                        var type = $(this).attr('data-type');
                        var vendor_id = {{ $vendor->id }}
                        var csrfToken = '{{ csrf_token() }}';
                        var date_from = $('#date-from-filter').val();
                        var date_to = $('#date-to-filter').val();

                        var url = '{{ route('vendor.order.export') }}' + '?_token=' + csrfToken + '&type=' + type + '&vendor_id=' + vendor_id + '&date_from=' + date_from + '&date_to=' + date_to;
                        window.open(url, '_blank');

                    });
                });
                $(document).on('click', '.button-make-vendor', function(e) {
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');
            var url = "{{ route('vendor.type.update', ['vendor' => ':id']) }}";
            var csrfToken = '{{ csrf_token() }}';

            url = url.replace(':id', id);
            Swal.fire({
            title: 'Are you sure?',
            text: $(this).attr('act-confirm'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#663259',
            cancelButtonColor: '#f64e60',
            confirmButtonText: 'Yes, Proceed'
          }).then(function (result) {
            if (result.isConfirmed) {
                let table = $('#dtable');


$.ajax({
    url: url,
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': csrfToken
    },
    data: {
        'type': type
    },
    success: function(response) {

        Swal.fire({
            icon: response.alert.icon,
            title: response.alert.title,
            text: response.alert.text,
            timer: 2000,
            timerProgressBar: true, // Display a progress bar indicating the remaining time
            showConfirmButton: false, // Hide the default "OK" button
        });
       window.location.reload();


    },
    error: function(xhr, status, error) {
        // Handle any errors
    }
});
            }
          });

        });
            </script>
        @endsection
