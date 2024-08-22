@extends('backend/layout/app', ['sidebar' => false])
@section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('Sliders') }}</a></li>
            </ol>
        </div>
        <h2 class="page-title" act-on="click">{{ __('Sliders') }}</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="d-flex">
            <div class="filter search">
                <div class="input-icon">
                    <input type="text" id="search" class="form-control" placeholder="Search {{ $search }}">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="15" cy="15" r="4" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                    </span>
                </div>
            </div>
            @if(hasPermission('slider.store'))
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-form">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                {{ __('Add New') }}
            </a>
            @endif
        </div>
    </div>
</div>
@endsection
@section('body')
<div class="row">
    <div class="col-lg-12">
         <div class="table-responsive">
            <table act-datatable="{{ route('slider.list') }}" search="#search" class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                    <tr class="bg-transparent">
                        <th name="id" priority="1" width="8%">SL</th>
                        <th name="name">Name</th>
                        <th name="vendor_name">Vendor Name</th>
                        <th name="actions" priority="7" width="12%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        @if(hasPermission('slider.store'))
        <!--  create form modal  -->
        <div class="modal fixed-left fade" id="create-form" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-aside" role="document">
                <div class="modal-content fix-padding">
                    <form act-on="submit" act-request="{{ route('slider.store') }}">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ __('Add Slider') }}</h4>
                                </div>
                                <div class="modal-body">
                            <div class="row">
        
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                                        <div>
                                            <input type="text" name="name"  required   class="form-control">
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
                                                    <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                                                @endforeach
                                            </select>                                           
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Image') }} </label>
                                        <div>
                                            <div class="custom-file">
                                                <input type="file" id="create-form-image" class="custom-file-input" name="image" hidden accept="image/*">
                                                <div class="preview">
                                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview"/>
                                                </div>
                                                <label class="custom-file-label" for="create-form-image">Choose file</label>
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
                                                    <option value="{{ $priorityKey }}">{{ $priorityValue }}</option>
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
                            <button type="submit" disabled="disabled"
                                class="btn btn-primary waves-effect waves-light mr-2 px-3">
                                Save
                            </button>
                        </div> 
                    </form>
 
                </div>
            </div>
        </div>
        <!-- /.modal -->
        @endif
        @if(hasPermission('slider.edit'))
        <!--  edit form modal  -->
        <div class="modal fixed-left fade" id="edit-form" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-aside" role="document">
                <div class="modal-content fix-padding">
                </div>
            </div>
        </div>
        <!-- /.modal -->
        @endif
    </div>
</div>
@endsection
