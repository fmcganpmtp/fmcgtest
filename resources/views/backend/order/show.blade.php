@extends('backend/layout/app', ['sidebar' => false])
@section('header')
    <div class="row align-items-center">
        <div class="col-md-4 col-sm-12">
            <div class="mb-1">
                <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('order') }}">{{ __('Order') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('show') }}</a></li>
                </ol>
            </div>
            <h2 class="page-title" act-on="click">{{ __('Order Details') }}</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
                @if (hasPermission('order'))
                    <a href="{{ route('order') }}" class="btn btn-primary">
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
    {{-- <div class="row"> --}}
    <div class="col-lg-12 vendor-show-input">

        <div class="card px-2">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3>Delivery Details</h3>
                            <div class="form-group">
                                <label><span>{{ __('Delivery Address') }}</span> : {{ $order->delivery_address }}</label>
                                <label><span>{{ __('Delivery Phone') }}</span> : {{ $order->delivery_phone }}</label>
                                <label><span>{{ __('Delivery Location') }}</span> : {{ $order->delivery_location }}</label>
                                <label><span>{{ __('Delivery Geo Location') }}</span> : {{ $order->delivery_geo_location }}</label>
                                <label><span>{{ __('Delivery Weight') }}</span> : {{ $order->delivery_weight }}</label>
                                <label><span>{{ __('Delivery Latitude') }}</span> : {{ $order->delivery_latitude }}</label>
                                <label><span>{{ __('Delivery Longitude') }}</span> : {{ $order->delivery_longitude }}</label>
                                <label><span>{{ __('Delivery Distance') }}</span> : {{ $order->delivery_distance }}</label>
                                <label><span>{{ __('Delivery Type') }}</span> : {{ $order->delivery_type }}</label>




                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3>Vendor Details</h3>
                            <div class="form-group">
                                <label><span>{{ __('Vendor Name') }}</span> : {{ $order->vendor_name }}</label>
                                <label><span>{{ __('Address') }}</span> : {{ $order->vendor_address }}</label>
                                <label><span>{{ __('Primary_contact_number') }}</span> : {{ $order->primary_contact_number }}</label>
                                <label><span>{{ __('Secondary_contact_number') }}</span> : {{ $order->secondary_contact_number }}</label>

                                <label><span>{{ __('Location') }}</span> : {{ $order->vendor_location }}</label>
                                <label><span>{{ __('Landmark') }}</span> : {{ $order->vendor_landmark }}</label>
                                <label><span>{{ __('State') }}</span> : {{ $order->vendor_state }}</label>
                                <label><span>{{ __('Pincode') }}</span> : {{ $order->vendor_pincode }}</label>
                                <label><span>{{ __(' Latitude') }}</span> : {{ $order->vendor_latitude }}</label>
                                <label><span>{{ __(' Longitude') }}</span> : {{ $order->vendor_longitude }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3>Payment Details</h3>
                            <div class="form-group">
                                <label><span>{{ __('Total Price Amount') }}</span> : {{ $order->total_price_amount }}</label>
                                <label><span>{{ __('Selling Price Discount') }}</span> : {{ $order->total_price_discount }}</label>

                                {{-- <label><span>{{ __('Total Amount') }}</span> : {{ $order->total_amount }}</label> --}}
                                <label><span>{{ __('Discount Amount') }}</span> : {{ $order->discount_amount }}</label>
                                <label><span>{{ __('Packaging Charge') }}</span> : {{ $order->packaging_charge }}</label>
                                <label><span>{{ __('Delivery Charge') }}</span> : {{ $order->delivery_charge }}</label>

                                <label><span>{{ __('Final Amount') }}</span> : {{ $order->final_amount }}</label>
                                @if($order->final_delivery_charge != '')
                                <label><span>{{ __('Final Delivery Charge') }}</span> : {{ $order->final_delivery_charge }}</label>
                                @endif
                                @if($order->final_bill_amount != '')
                                <label><span>{{ __('Final Bill Amount') }}</span> : {{ $order->final_bill_amount  }}</label>
                                @endif


                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3>Other Information</h3>
                            <div class="form-group">
                                <label><span>{{ __('Discount Code') }}</span> : {{ $order->discount_code }}</label>
                                <label><span>{{ __('Commission Amount') }}</span> : {{ $order->commission_amount }}</label>

                                {{-- <label><span>{{ __('Total Amount') }}</span> : {{ $order->total_amount }}</label> --}}
                                <label><span>{{ __('Note') }}</span> :{{ $order->note }}</label>
                                @if ($order->comments != '')
                                        <label><span>{{ __('Comment') }}</span> : {{ $order->comments }}</label>
                                @endif

                                <label><span>{{ __('User Name') }}</span> :{{ $order->user_name }}</label>
                                <label><span>{{ __('Status') }}</span> : <span class="text-danger">{{ ucfirst($order->status) }}</span></label>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3>Order Status</h3>
                            <div class="form-group">
                               @foreach($order_status as $row)
                                <label><span>{{ __($row->status) }}</span> : {{date('Y-m-d H:i:s', strtotime($row->created_at))}}</label>
                            @endforeach
                            <label>
                                <span>{{ __('Order Confirm') }}</span> :
                                @if($order->is_confirm == 1)
                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                                @endif

                            </label>
                            <label>
                                <span>{{ __('Bill Confirm') }}</span> :
                                @if($order->is_bill_confirm == 1)
                                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 12.6111L8.92308 17.5L20 6.5" stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>                         @endif

                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3>Payment Status Details</h3>
                            <div class="form-group">
                                <label>
                                    <span>{{ __('Payment Status') }}</span> :
                                    @if($order->payment_status === 'pending')
                                        Pending
                                    @else
                                        {{ $order->payment_status }}
                                    @endif
                                </label>                                <label>
                                    <span>{{ __('Payment Method') }}</span> :
                                    @if($order->payment_method === 'cod')
                                        Cash On Delivery
                                    @else
                                        {{ $order->payment_method }}
                                    @endif
                                </label>
                                <label><span>{{ __('Bill Amount') }}</span> : {{ $order->bill_amount }}</label>

                                <label><span>{{ __('Payment Note') }}</span> : {{ $order->comments }}</label>

                            </div>
                        </div>
                    </div>

                    @if($order_bills && $order_bills->isNotEmpty())
                 <div class="col-md-4 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3>Bill Images</h3>
                            <div class="form-group">
                                @foreach($order_bills as $image)
                                    @if(isset($image->bill_image))
                                    <a href="{{ asset('uploads/' . $image->bill_image) }}" target="_blank">
                                        <img src="{{ asset('uploads/' . $image->bill_image) }}" class="img-fluid w-25" alt="Bill Image">
                                    </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif


                </div>

            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-lg-12">

            <div class="table-responsive">
                <div class="row align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <h2 class="page-title" act-on="click">{{ __('Order Items') }}</h2>
                    </div>
                </div>
                <table act-datatable="{{ route('orderitems.list', ['order' => $order->id]) }}" class="table card-table table-vcenter text-nowrap datatable"id="dtable">
                    <thead>
                        <tr class="bg-transparent">
                            <th name="id" priority="1" width="8%">SL</th>
                            <th name="product_name">Product</th>
                            <th name="product_type">Type</th>
                            <th name="product_code">Product Code</th>
                            <th name="product_quantity">Quantity</th>

                            <th name="menu">Menu</th>
                            <th name="submenu">Submenu</th>
                            <th name="brand">Brand</th>
                            <th name="weight">Weight</th>
                            <th name="price">Price</th>
                            <th name="selling_price">Selling Price</th>
                            <th name="status">Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- </div> --}}
@endsection
