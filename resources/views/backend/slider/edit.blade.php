<form method="post" act-on="submit" act-request="{{ route('slider.update', ['slider' => $slider->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit Slider') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="name" value="{{ $slider->name }}"  required   class="form-control">

                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Vendor Name') }} <span class="text-danger">*</span></label>
                    <div>
                        <select name="vendor_id" required class="form-select select2">
                            <option disabled selected value=""></option>
                            @foreach($vendors as $vendor)

                                @if($vendor->id == $slider->vendor_id)
                                <option value="{{$vendor->id}}" selected>{{$vendor->name}}</option>
                                @else
                                <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                @endif

                            @endforeach
                        </select>
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
                                    @if( $slider->image == '')
                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="img-thumbnail custom-file-preview" width="150"/>
                                    @else
                                    <img src="{{ asset('uploads/' . $slider->image) }}" class="img-thumbnail custom-file-preview" width="150"/>
                                    @endif
                                </div>
                                <label class="custom-file-label" for="edit-form-image">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                <label>{{ __('Priority') }}  <span class="text-danger">*</span></label>
                    <div>
                        <select name="priority" required class="form-select select2">
                            @foreach(priority() as $priorityKey => $priorityValue)

                                @if($slider->priority == $priorityKey)
                                    <option value="{{ $priorityKey }}" selected>{{ $priorityValue }}</option>
                                @else
                                    <option value="{{ $priorityKey }}">{{ $priorityValue }}</option>
                                @endif

                            @endforeach
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
