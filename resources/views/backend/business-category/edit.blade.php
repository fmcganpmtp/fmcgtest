<form method="post" act-on="submit" act-request="{{ route('business.category.update', ['businessCategory' => $businessCategory->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit Business Category') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">        
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Title') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="title" value="{{ $businessCategory->title }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Short Description') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="short_description" value="{{ $businessCategory->short_description }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
 
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Title Color') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="color" name="title_color" value="{{ $businessCategory->title_color }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Short Description Color') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="color" name="short_description_color" value="{{ $businessCategory->short_description_color }}"  required   class="form-control">
 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Bg Color') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="color" name="bg_color" value="{{ $businessCategory->bg_color }}"  required   class="form-control">
 
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
                                    @if( $businessCategory->image == '')
                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="img-thumbnail custom-file-preview" width="150"/>
                                    @else
                                    <img src="{{ asset('uploads/' . $businessCategory->image) }}" class="img-thumbnail custom-file-preview" width="150"/>
                                    @endif
                                </div>
                                <label class="custom-file-label" for="edit-form-image">Choose file</label>
                            </div>                                    
                        </div>
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