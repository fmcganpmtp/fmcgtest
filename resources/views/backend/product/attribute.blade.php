<div class="row" >
@if($attribute && $attribute->variants)
    @foreach($attribute->variants as $variant)
    <div class="col-lg-4 col-sm-12">
        <div class="form-group">
            <label>{{ $variant->name }} <span class="text-danger">*</span></label>
            <div>
                <select name="variants[{{ $variant->id }}]" required class="form-select select2">
                    <option selected disabled value=""></option>
                    @if($variant->options)
                        @foreach($variant->options as $option)
                        <option value="{{$option->id}}">{{$option->value}}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
    </div>
    @endforeach
@endif
</div>