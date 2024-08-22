<form method="post" act-on="submit" act-request="{{ route('coupon.update', ['coupon' => $coupon->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit Coupon') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Title') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="title" value="{{ $coupon->title }}"  required   class="form-control">

                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Vendor') }}</label>
                    <div>
                        <select name="vendor_id"  class="form-select select2">
                            <option selected value="">Select Vendor</option>
                            @foreach($vendors as $vendor)
                                <option value="{{$vendor->id}}"{{($coupon->vendor_id==$vendor->id)?'selected':''}}>{{ucfirst($vendor->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Description') }} </label>
                    <div>
                        <input type="text" name="description" value="{{ $coupon->description }}"   class="form-control">

                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('T&C') }} </label>
                    <div>
                        <textarea name="tc" class="form-control">{{ $coupon->tc }}</textarea>


                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Code') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="code" value="{{ $coupon->code }}"  required   class="form-control">

                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Min Cart Amount') }} </label>
                    <div>

                        <input type="text" name="min_cart_amount" value="{{ $coupon->min_cart_amount }}"   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Max Cart Amount') }} </label>
                    <div>
                        <input type="text" name="max_cart_amount" value="{{ $coupon->max_cart_amount }}"   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('On Which Order') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="on_which_order" value="{{ $coupon->on_which_order }}"  required   class="form-control">

                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Discount Amount') }}  <span class="text-danger">*</span></label>
                    <div>

                        <input type="text" name="discount_amount" value="{{ $coupon->discount_amount }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Status') }}  <span class="text-danger">*</span></label>
                    <div>
                        <select name="status" required class="form-select select2">
                        <option value="draft" @if($coupon->status == 'draft') {{ 'selected' }} @endif>Draft</option>
                        <option value="private"@if($coupon->status == 'private') {{ 'selected' }} @endif>Private</option>
                        <option value="published" @if($coupon->status == 'published') {{ 'selected' }} @endif>Published</option>
                        <option value="expired" @if($coupon->status == 'expired') {{ 'selected' }} @endif>Expired</option>
                        <option value="deleted" @if($coupon->status == 'deleted') {{ 'selected' }} @endif>Deleted</option>

                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary waves-effect mr-2 px-3">
            Cancel
        </button>
        <button type="submit" disabled="disabled" class="btn btn-primary waves-effect waves-light mr-2 px-3">
            Update
        </button>
    </div>
</form>
