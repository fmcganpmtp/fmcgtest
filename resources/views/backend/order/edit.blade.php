@extends('backend/layout/app', ['sidebar' => false])
<style>
  .image-container {
    display: flex;
    flex-wrap: wrap;
}

.image-wrapper {
    position: relative;
    margin: 5px;
}

.delete-icon {
    position: absolute;
    top: 0;
    right: 0;
    cursor: pointer;
    z-index: 1; /* Ensure the delete icon is above the image */
}

</style>
@section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                <li class="breadcrumb-item"><a href="{{ route('order') }}">{{ __('Order') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('Edit') }}</a></li>
            </ol>
        </div>
        <h2 class="page-title" act-on="click">{{ __('Edit Order') }}</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="d-flex">
            @if(hasPermission('order'))
            <a href="{{ route('order') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="9" y1="6" x2="20" y2="6" /><line x1="9" y1="12" x2="20" y2="12" /><line x1="9" y1="18" x2="20" y2="18" /><line x1="5" y1="6" x2="5" y2="6.01" /><line x1="5" y1="12" x2="5" y2="12.01" /><line x1="5" y1="18" x2="5" y2="18.01" /></svg>
                {{ __('View All')}}
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
                <form act-on="submit" act-request="{{ route('order.update', ['order' => $order->id]) }}" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="patch">
                <div class="row">
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Geo Location') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_geo_location" value="{{ $order->delivery_geo_location }}"  required   class="form-control">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Latitude') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_latitude" value="{{ $order->delivery_latitude }}"  required   class="form-control">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Longitude') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_longitude" value="{{ $order->delivery_longitude }}"  required   class="form-control">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Address') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_address" value="{{ $order->delivery_address }}"  required   class="form-control">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Location') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_location" value="{{ $order->delivery_location }}"  required   class="form-control">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Phone') }} </label>
                                <div>
                                    <input type="text" name="delivery_phone" value="{{ $order->delivery_phone }}"   class="form-control">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Type') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="delivery_type" value="{{ $order->delivery_type }}"  required   class="form-control">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Weight') }}  <span class="text-danger">*</span></label>
                                <div>

                                    <input type="text" name="delivery_weight" value="{{ $order->delivery_weight }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Distance') }}  <span class="text-danger">*</span></label>
                                <div>

                                    <input type="text" name="delivery_distance" value="{{ $order->delivery_distance }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Total Price Amount') }} </label>
                                <div>

                                    <input type="text" name="total_price_amount" value="{{ $order->total_price_amount }}"   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Total Price Discount') }} </label>
                                <div>

                                    <input type="text" name="total_price_discount" value="{{ $order->total_price_discount }}"   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Charge') }} </label>
                                <div>

                                    <input type="text" name="delivery_charge" value="{{ $order->delivery_charge }}"   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Discount Code') }} </label>
                                <div>

                                    <textarea class="form-control"  name="discount_code" rows="3">{{ $order->discount_code }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Discount Amount') }}  <span class="text-danger">*</span></label>
                                <div>

                                    <input type="text" name="discount_amount" value="{{ $order->discount_amount }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Total Amount') }}  <span class="text-danger">*</span></label>
                                <div>

                                    <input type="text" name="total_amount" value="{{ $order->total_amount }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Final Amount') }}  <span class="text-danger">*</span></label>
                                <div>

                                    <input type="text" name="final_amount" value="{{ $order->final_amount }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Commission Amount') }}  <span class="text-danger">*</span></label>
                                <div>

                                    <input type="text" name="commission_amount" value="{{ $order->commission_amount }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Note') }} </label>
                                <div>

                                    <textarea class="form-control"  name="note" rows="3">{{ $order->note }}</textarea>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Status') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <input type="text" name="status" value="{{ $order->status }}"  required   class="form-control">

                                </div>
                            </div>
                        </div> --}}

                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                                <label>{{ __('Status') }}  <span class="text-danger">*</span></label>
                                <div>
                                    <select name="status" id="order_filter" class="form-select select2">
                                        <option disabled value="">Select Status</option>

                                        @foreach($status as $row)

                                            <option value="{{$row}}"{{($row==$order->status)?'selected':''}}>{{ucfirst($row)}}</option>

                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('User Name') }} <span class="text-danger">*</span></label>
                                <div>
                                    <select name="assign_user_id"  class="form-select select2">
                                        <option disabled selected value=""></option>
                                        @foreach($users as $user)

                                            @if($user->id == $order->assign_user_id)
                                            <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                            @else
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endif

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

                                            @if($user->id == $order->user_id)
                                            <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                            @else
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endif

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

                                            @if($vendor->id == $order->vendor_id)
                                            <option value="{{$vendor->id}}" selected>{{$vendor->name}}</option>
                                            @else
                                            <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                            @endif

                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Date') }} </label>
                                <div>
                                  <input type="date" class="form-control" name="delivery_date" value="{{$order->delivery_date}}"  min="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                            <label>{{ __('Delivery Time') }} </label>
                                <div>
                                  <input type="text" class="form-control" name="delivery_time" value="{{$order->delivery_time}}">
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-4 col-sm-12">
                            <div class="form-group">
                        <label class="w-100">
                            <span>{{ __('Payment Status') }}</span> :
                            <div>
                                <input type="text" class="form-control" name="payment_status" value="{{ $order->payment_status }}">
                            </div>
                        </label>
                    </div>
                </div>


                <div class="col-lg-4 col-sm-12">
                    <div class="form-group">
                <label class="w-100">
                    <span>{{ __('Payment Note') }}</span> :
                    <div>
                        <input type="text" class="form-control" name="comments" value="{{ $order->comments }}">
                    </div>
                </label>
            </div>
        </div>



<div class="col-lg-4 col-sm-12">
    <div class="form-group">
        <label class="w-100">
            <span>{{ __('Payment Method') }}</span> :
            <div>
                <select  name="payment_method"  class="form-select select2">
                    @foreach($paymentStatusOptions as $option)
                        <option value="{{ $option }}" @if($order->payment_method === $option) selected @endif>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
        </label>
    </div>
</div>


<div class="col-lg-4 col-sm-12">
    <div class="form-group">
<label class="w-100">
    <span>{{ __('Bill Amount') }}</span> :
    <div>
        <input type="text" class="form-control" name="bill_amount" value="{{ $order->bill_amount }}">
    </div>
</label>
</div>
</div>


<div class="col-lg-4 col-sm-12">
    <div class="form-group">
        <label>{{ __('Order Confirm') }}</label>
        <div>
            <label>
                <input type="radio" name="is_confirm" value="1" {{ $order->is_confirm === 1 ? 'checked' : '' }}>
                Yes
            </label>
            <label>
                <input type="radio" name="is_confirm" value="0" {{ $order->is_confirm === 0 ? 'checked' : '' }}>
                No
            </label>
        </div>
    </div>
</div>


<div class="col-lg-4 col-sm-12">
    <div class="form-group">
        <label>{{ __('Bill Confirm') }}</label>
        <div>
            <label>
                <input type="radio" name="is_bill_confirm" value="1" {{ $order->is_bill_confirm == 1 ? 'checked' : '' }}>
                Yes
            </label>
            <label>
                <input type="radio" name="is_bill_confirm" value="0" {{ $order->is_bill_confirm == 0 ? 'checked' : '' }}>
                No
            </label>
        </div>
    </div>
</div>


<div class="col-lg-4 col-sm-12">
    <div class="form-group">
        <label>{{ __('Upload Bill Images') }}</label>
        <div class="image-container" style="position: relative;">
            @foreach($bill_image as $key => $image)
                @if(isset($image->bill_image))
                    <div class="image-wrapper">
                        <a href="{{ asset('uploads/' . $image->bill_image) }}" target="_blank">
                            <img src="{{ asset('uploads/' . $image->bill_image) }}" alt="Bill Image" width="50px" height="50px" name="imageid">
                        </a>
                        <svg class="delete-icon" width="12" height="16" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg" data-image-key="{{ $image->id }}">
                            <path fill="#FF0000" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/>
                        </svg>
                    </div>
                @endif
            @endforeach
        </div>
<br>
<div id="success-popup" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
            </div>
            <div class="modal-body">
                <p id="success-message"></p>
            </div>
        </div>
    </div>
</div>
    <div id="newRow" style="margin-top: auto; margin-bottom: auto;">
        <button id="addRow" type="button" class="btn btn-success mb-3">Add Image</button>
    </div>
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
@section('script')
<script>

 //image appending
    $("#addRow").click(function() {
    var html = '';
    html += '<div id="inputFormRow">';
    html += '<div class="form-group">';
    html += '<strong>Bill Image:</strong>';
    html += '<div class="d-flex align-items-center">';
    html += '<input type="file" name="old_image[]" value="{{ old('image') }}" class="form-control" autocomplete="off">';
    html += '<button id="removeRow" type="button" class="btn btn-danger custom-btn ml-2" style="width:37px;height:37px;margin-left">✕</button>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    $('#newRow').append(html);
    });
    // remove row
    $(document).on('click', '#removeRow', function() {
        $(this).closest('#inputFormRow').remove();
    });
    $('.delete-icon').on('click', function() {
    let key = $(this).data('image-key');
    let imageId = key;
    Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this Bill image.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00665c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed){
                let $this = $(this);
                $.ajax({
                    type: "post",
                    data: {
                        id: imageId,
                        "_token": "{{ csrf_token() }}"
                    },
                    url: "{{ route('order.deleteimage') }}",
                    success: function(response) {
                if (response && response.success) {
                    // console.log('Image deleted successfully:', response.image_id);
                    let deletedImageId = response.image_id;
                    let $deletedImageWrapper = $('[data-image-key="' + deletedImageId + '"]').closest('.image-wrapper');
                    $deletedImageWrapper.remove();
                    // console.log('Image wrapper removed for image ID:', deletedImageId);
                } else {
                    handleDeleteError('Failed to delete image');
                }
            },
            error: function(xhr, status, error) {
                handleDeleteError('Error deleting image: ' + error);
            }
            });
        }
    });
});
function handleDeleteError(errorMessage) {
    console.error(errorMessage);
}
</script>
@endsection
