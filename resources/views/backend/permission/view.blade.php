@foreach( $permissions as $permissionKey => $permissionOptions )
    <div class="form-group row">
        <label class="col-md-2">{{ $permissionKey }}</label>
        <div class="col-lg-12">
            @foreach( $permissionOptions as $permissionOptionKey => $permissionOptionValue )
                <div class="form-check form-check-inline">
                    @if(in_array($permissionKey . '-' . $permissionOptionKey, $data))
                    <input class="form-check-input" type="checkbox" checked id="{{ $permissionKey }}-{{ $permissionOptionKey }}" name="permissions[]" value="{{ $permissionKey }}-{{ $permissionOptionKey }}">
                    @else
                    <input class="form-check-input" type="checkbox" id="{{ $permissionKey }}-{{ $permissionOptionKey }}" name="permissions[]" value="{{ $permissionKey }}-{{ $permissionOptionKey }}">
                    @endif
                    <label class="form-check-label font-weight-light" for="{{ $permissionKey }}-{{ $permissionOptionKey }}">{{ $permissionOptionKey }}</label>
                </div>
            @endforeach
        </div>
    </div>
@endforeach
