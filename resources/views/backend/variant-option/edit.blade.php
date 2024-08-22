<form method="post" act-on="submit" act-request="{{ route('variant.option.update', ['variantOption' => $variantOption->id]) }}">
    <div class="modal-header">
        <h4 class="modal-title">{{ __('Edit Variant Option') }}</h4>
    </div>
    <div class="modal-body">
        <input type="hidden" name="_method" value="patch">        
        <div class="row">

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Variant Name') }} <span class="text-danger">*</span></label>
                    <div>
                        <select name="variant_id" required class="form-select select2">
                            <option disabled selected value=""></option>
                            @foreach($variants as $variant)
                                
                                @if($variant->id == $variantOption->variant_id)
                                <option value="{{$variant->id}}" selected>{{$variant->name}}</option>
                                @else
                                <option value="{{$variant->id}}">{{$variant->name}}</option>
                                @endif
                            
                            @endforeach
                        </select>                                           
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label>{{ __('Value') }}  <span class="text-danger">*</span></label>
                    <div>
                        <input type="text" name="value" value="{{ $variantOption->value }}"  required   class="form-control">
 
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