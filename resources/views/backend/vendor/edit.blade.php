<form method="post" act-on="submit" act-request="{{ route('vendor.update', ['vendor' => $vendor->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit Vendor') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">        
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="name" value="{{ $vendor->name }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Image') }} </label>
                    <div>
 
 
                        <div>
                            <div class="custom-file">
                                <input type="file" id="edit-form-image" class="custom-file-input" name="image" hidden accept="image/*">
                                <div class="preview">
                                    @if( $vendor->image == '')
                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="img-thumbnail custom-file-preview" width="150"/>
                                    @else
                                    <img src="{{ asset('uploads/' . $vendor->image) }}" class="img-thumbnail custom-file-preview" width="150"/>
                                    @endif
                                </div>
                                <label class="custom-file-label" for="edit-form-image">Choose file</label>
                            </div>                                    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Logo') }} </label>
                    <div>
 
                        <textarea class="form-control"  name="logo" rows="3">{{ $vendor->logo }}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Star Rating') }}  <span class="text-danger">*</span></label>
                    <div>
 
                        <input type="text" name="star_rating" value="{{ $vendor->star_rating }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Gst Number') }} </label>
                    <div>
                        <input type="text" name="gst_number" value="{{ $vendor->gst_number }}"   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Fssai Number') }} </label>
                    <div>
                        <input type="text" name="fssai_number" value="{{ $vendor->fssai_number }}"   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Contact Person') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="contact_person" value="{{ $vendor->contact_person }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Primary Contact Number') }} </label>
                    <div>
                        <input type="text" name="primary_contact_number" value="{{ $vendor->primary_contact_number }}"   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Secondary Contact Number') }} </label>
                    <div>
                        <input type="text" name="secondary_contact_number" value="{{ $vendor->secondary_contact_number }}"   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Address') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="address" value="{{ $vendor->address }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Location') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="location" value="{{ $vendor->location }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Landmark') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="landmark" value="{{ $vendor->landmark }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('State') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="state" value="{{ $vendor->state }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('District') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="district" value="{{ $vendor->district }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Pincode') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="pincode" value="{{ $vendor->pincode }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Latitude') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="latitude" value="{{ $vendor->latitude }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Longitude') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="longitude" value="{{ $vendor->longitude }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Allow Orders Within') }}  <span class="text-danger">*</span></label>
                    <div>
 
                        <input type="text" name="allow_orders_within" value="{{ $vendor->allow_orders_within }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Maximum Weight To Deliver') }}  <span class="text-danger">*</span></label>
                    <div>
 
                        <input type="text" name="maximum_weight_to_deliver" value="{{ $vendor->maximum_weight_to_deliver }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Free Delivery Upto') }}  <span class="text-danger">*</span></label>
                    <div>
 
                        <input type="text" name="free_delivery_upto" value="{{ $vendor->free_delivery_upto }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Delivery Fee Per Km') }}  <span class="text-danger">*</span></label>
                    <div>
 
                        <input type="text" name="delivery_fee_per_km" value="{{ $vendor->delivery_fee_per_km }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Avoide Delivery Fee') }}  <span class="text-danger">*</span></label>
                    <div>
 
                        <input type="text" name="avoide_delivery_fee" value="{{ $vendor->avoide_delivery_fee }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Commission Percentage') }}  <span class="text-danger">*</span></label>
                    <div>
 
                        <input type="text" name="commission_percentage" value="{{ $vendor->commission_percentage }}"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Online') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="online" value="{{ $vendor->online }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Status') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="status" value="{{ $vendor->status }}"  required   class="form-control">
 
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