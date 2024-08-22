___extends('backend/layout/app', ['sidebar' => false])

___section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">{{ __('Application') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">__[ __('{{ $plural }}') ]__</a></li>
            </ol>
        </div>

        <h2 class="page-title" act-on="click">__[ __('{{ $plural }}') ]__</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="d-flex">
            <div class="filter search">
                <div class="input-icon">
                    <input type="text" id="search" class="form-control" placeholder="Search __[ $search ]__">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="15" cy="15" r="4" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                    </span>
                </div>
            </div>
            ___if(hasPermission('{{ $route }}.store'))
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-form">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                __[ __('Add New') ]__
            </a>
            ___endif
        </div>
    </div>
</div>
___endsection

___section('body')
<div class="row">
    <div class="col-lg-12">
         <div class="table-responsive">
            <table act-datatable="__[ route('{{ $route }}.list') ]__" search="#search" class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                    <tr class="bg-transparent">
                        <th name="id" priority="1" width="8%">SL</th>
@foreach($items as $item)
@if($item['name']  != 'id' && $item['type'] != 'image')
                        <th name="{{ $item['name'] }}">{{ $item['label'] }}</th>
@endif
@endforeach
@foreach($references as $referenceKey => $reference)
                        <th name="{{ $reference['identity'] }}">{{ $reference['label'] }}</th>
@endforeach
                        <th name="actions" priority="7" width="12%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        ___if(hasPermission('{{ $route }}.store'))
        <!--  create form modal  -->
        <div class="modal fixed-left fade" id="create-form" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-aside" role="document">
                <div class="modal-content fix-padding">

                    <form act-on="submit" act-request="__[ route('{{ $route }}.store') ]__">
                        <div class="modal-header">
                            <h4 class="modal-title">__[ __('Add {{ $singular }}') ]__</h4>
                                </div>

                                <div class="modal-body">

                            <div class="row">
@foreach($items as $item)
@if($item['name']  != 'id')
        
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>__[ __('{{ $item['label'] }}') ]__ @if($item['required']) <span class="text-danger">*</span>@endif</label>
                                        <div>
@if($item['type']  == 'text' || $item['type']  == 'integer')
                                            <input type="text" name="{{ $item['name'] }}" @if($item['required']) required @endif  class="form-control">
@endif
@if($item['type']  == 'email')
                                            <input type="text" name="{{ $item['name'] }}" @if($item['required']) required @endif  class="form-control input-mask" data-inputmask="'alias': 'email'">
@endif
@if($item['type']  == 'mobile')
                                            <input type="text" name="{{ $item['name'] }}" @if($item['required']) required @endif  class="form-control input-mask" data-inputmask="'mask': '9999999999'">
@endif
@if($item['type']  == 'decimal')
                                            <input type="text" name="{{ $item['name'] }}" @if($item['required']) required @endif  class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': {{ decimalPlace() }}, 'allowMinus': false, 'rightAlign': false">
@endif
@if($item['type']  == 'image')
                                            <div class="custom-file">
                                                <input type="file" id="create-form-image" class="custom-file-input" name="{{ $item['name'] }}" hidden accept="image/*">
                                                <div class="preview">
                                                    <img src="__[ asset('assets/backend/img/upload-image.png') ]__" class="custom-file-preview"/>
                                                </div>
                                                <label class="custom-file-label" for="create-form-image">Choose file</label>
                                            </div>  

@endif
@if($item['type']  == 'textarea')
                                            <textarea class="form-control" @if($item['required']) required @endif name="{{ $item['name'] }}" rows="3"></textarea>
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
                                                    <option value="__[${{ $reference['singular'] }}->{{ $reference['column'] }}]__">__[${{ $reference['singular'] }}->{{ $reference['name'] }}]__</option>
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
                            <button type="submit" disabled="disabled"
                                class="btn btn-primary waves-effect waves-light mr-2 px-3">
                                {{ __('Save') }}
                            </button>
                        </div> 

                    </form>
 
                </div>
            </div>
        </div>
        <!-- /.modal -->
        ___endif
        ___if(hasPermission('{{ $route }}.edit'))
        <!--  edit form modal  -->
        <div class="modal fixed-left fade" id="edit-form" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-aside" role="document">
                <div class="modal-content fix-padding">
                </div>
            </div>
        </div>
        <!-- /.modal -->
        ___endif
    </div>
</div>
___endsection
