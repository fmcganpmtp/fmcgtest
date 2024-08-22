<form method="post" act-on="submit" act-request="__[ route('{{ $route }}.update', ['{{ $variable }}' => ${{ $variable }}->id]) ]__">
    <div class="modal-header">
        <h4 class="modal-title">__[ __('Edit {{ $singular }}') ]__</h4>
    </div>

    <div class="modal-body">

        @method('patch')
        
        <div class="row">
@foreach($items as $item)
@if($item['name']  != 'id')
            <div class="col-sm-12">
                <div class="form-group">
                <label>__[ __('{{ $item['label'] }}') ]__ @if($item['required']) <span class="text-danger">*</span>@endif</label>
                    <div>
@if($item['type']  == 'text' || $item['type']  == 'integer')
                        <input type="text" name="{{ $item['name'] }}" value="__[ ${{ $variable }}->{{ $item['name'] }} ]__" @if($item['required']) required @endif  class="form-control">
@endif 
@if($item['type']  == 'email')
                        <input type="text" name="{{ $item['name'] }}" value="__[ ${{ $variable }}->{{ $item['name'] }} ]__" @if($item['required']) required @endif  class="form-control input-mask" data-inputmask="'alias': 'email'">
@endif
@if($item['type']  == 'mobile')
                        <input type="text" name="{{ $item['name'] }}" value="__[ ${{ $variable }}->{{ $item['name'] }} ]__" @if($item['required']) required @endif  class="form-control input-mask" data-inputmask="'mask': '9999999999'">
@endif
@if($item['type']  == 'decimal')
                        <input type="text" name="{{ $item['name'] }}" value="__[ ${{ $variable }}->{{ $item['name'] }} ]__" @if($item['required']) required @endif  class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': {{ decimalPlace() }}, 'allowMinus': false, 'rightAlign': false">
@endif
@if($item['type']  == 'image')
 
                        <div>
                            <div class="custom-file">
                                <input type="file" id="edit-form-image" class="custom-file-input" name="{{ $item['name'] }}" hidden accept="image/*">
                                <div class="preview">
                                    ___if( ${{ $variable}}->{{ $item['name'] }} == '')
                                    <img src="__[ asset('assets/backend/img/upload-image.png') ]__" class="img-thumbnail custom-file-preview" width="150"/>
                                    ___else
                                    <img src="__[ asset('uploads/' . ${{ $variable }}->{{ $item['name'] }}) ]__" class="img-thumbnail custom-file-preview" width="150"/>
                                    ___endif
                                </div>
                                <label class="custom-file-label" for="edit-form-image">Choose file</label>
                            </div>                                    
                        </div>



@endif
@if($item['type']  == 'textarea')
                        <textarea class="form-control" @if($item['required']) required @endif name="{{ $item['name'] }}" rows="3">__[ ${{ $variable }}->{{ $item['name'] }} ]__</textarea>
@endif
                    </div>
                </div>
            </div>


@endif
@endforeach
@foreach($references as $referenceKey => $reference)
            <div class="col-sm-12">
                <div class="form-group">
                <label>__[ __('{{ $reference['label'] }}') ]__ <span class="text-danger">*</span></label>
                    <div>
                        <select name="{{ $referenceKey }}" required class="form-select select2">
                            <option disabled selected value=""></option>
                            ___foreach(${{ $reference['variable'] }} as ${{ $reference['singular'] }})
                                
                                ___if(${{ $reference['singular'] }}->{{ $reference['column'] }} == ${{ $variable }}->{{ $referenceKey }})
                                <option value="__[${{ $reference['singular'] }}->{{ $reference['column'] }}]__" selected>__[${{ $reference['singular'] }}->{{ $reference['name'] }}]__</option>
                                ___else
                                <option value="__[${{ $reference['singular'] }}->{{ $reference['column'] }}]__">__[${{ $reference['singular'] }}->{{ $reference['name'] }}]__</option>
                                ___endif
                            
                            ___endforeach
                        </select>                                           
                    </div>
                </div>
            </div>
@endforeach
        </div>

    </div>

    <div class="modal-footer">
        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary waves-effect mr-2 px-3">
            {{ __('Cancel') }}
        </button>
        <button type="submit" disabled="disabled" class="btn btn-primary waves-effect waves-light mr-2 px-3">
            {{ __('Update') }}
        </button>
    </div> 

</form>