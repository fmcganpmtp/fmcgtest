<form method="post" act-on="submit" act-request="{{ route('attribute.update', ['attribute' => $attribute->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit Attribute') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">        
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="name" value="{{ $attribute->name }}"  required   class="form-control">
                    </div>
                </div>
            </div>
 
            <div class="col-lg-12">
                <div class="form-group">
                <label>{{ __('Variants') }}  <span class="text-danger">*</span></label>
                    <div>
                        <select name="variants[]" multiple required class="form-select select2">
                            @foreach($variants as $variant)
                                <option value="{{ $variant->id }}" @if(in_array( $variant->id, $attribute->variants->pluck('id')->all())) {{'selected'}} @endif>{{ $variant->name }}</option>
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