___extends('backend/layout/app', ['sidebar' => false])

___section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">{{ __('Application') }}</a></li>
                <li class="breadcrumb-item"><a href="__[ route('{{ $route }}') ]__">__[ __('{{ $singular }}') ]__</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:">__[ __('New') ]__</a></li>
            </ol>
        </div>

        <h2 class="page-title" act-on="click">__[ __('New {{ $singular }}') ]__</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="d-flex">
            ___if(hasPermission('{{ $route }}'))
            <a href="__[ route('{{ $route }}') ]__" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="9" y1="6" x2="20" y2="6" /><line x1="9" y1="12" x2="20" y2="12" /><line x1="9" y1="18" x2="20" y2="18" /><line x1="5" y1="6" x2="5" y2="6.01" /><line x1="5" y1="12" x2="5" y2="12.01" /><line x1="5" y1="18" x2="5" y2="18.01" /></svg>
                {{ __('View All') }}
            </a>
            ___endif
        </div>
    </div>
</div>
___endsection

___section('body')
<div class="row">
    <div class="col-lg-12">
 
        <div class="card px-2">
            <div class="card-body">
                <form act-on="submit" act-request="__[ route('{{ $route }}.store') ]__">
 
                <div class="row">
@foreach($items as $item)
@if($item['name']  != 'id')
 


                        <div class="col-lg-4 col-sm-12">
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
                        <div class="col-lg-4 col-sm-12">
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
 
                    <div class="row mb-3">
                        <div class="col-lg-4 col-sm-12">
                            <div class="form-footer mt-3">

                                <button type="reset" class="btn btn-secondary">
                                    {{ __('Cancel') }}
                                </button>

                                <button type="submit" class="btn btn-primary ms-2">
                                    {{ __('Save') }}
                                </button>

                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>


    </div>
</div>
___endsection
