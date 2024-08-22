@extends('backend/layout/app', ['sidebar' => false])
@section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">{{ __('Application') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('Permissions') }}</a></li>
            </ol>
        </div>
        <h2 class="page-title" act-on="click">{{ __('Permissions') }}</h2>
    </div>
</div>
@endsection
@section('body')
<div class="row p-4 pt-3">
    <div class="col-lg-12">

        @if(hasPermission('permission.update'))
        <form method="post" act-on="submit" act-request="{{ route('permission.update') }}">
            @method('patch')
            @endif
            <div class="row">
                <div class="col-lg-4 col-sm-12 ps-0 pb-3">
                    <div class="form-group">
                        <label>{{ __('Role') }}</label>
                        <div>
                            <select id="role_id" name="role_id" class="custom-select select2" act-on="change" act-request="{{ route('permission.edit')}}">
                                <option selected value="">Select</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div id="permissions" class="col-lg-12 col-sm-12">
                    @foreach( $permissions as $permissionKey => $permissionOptions )
                        <div class="form-group row">
                            <label class="col-md-2">{{ $permissionKey }}</label>
                            <div class="col-lg-12">
                                @foreach( $permissionOptions as $permissionOptionKey => $permissionOptionValue )
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="{{ $permissionKey }}-{{ $permissionOptionKey }}" name="permissions[]" value="{{ $permissionKey }}-{{ $permissionOptionKey }}">
                                        <label class="form-check-label font-weight-light" for="{{ $permissionKey }}-{{ $permissionOptionKey }}">{{ $permissionOptionKey }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            @if(hasPermission('permission.update'))
            <div class="row mb-3">
                <div class="col-lg-4 col-sm-12">
                    <div class="form-footer mt-3">
                        <button type="reset" class="btn btn-secondary">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary ms-2">
                            Save
                        </button>
                    </div>
                </div>
            </div>

        </form>
        @endif
    </div>
</div>
@endsection
