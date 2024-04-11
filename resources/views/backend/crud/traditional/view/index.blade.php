___extends('backend/layout/app')

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
                    <input type="text" id="search" class="form-control" value="__[ $search ]__" placeholder="Search __[ __('{{ $plural }}') ]__">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="15" cy="15" r="4" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                    </span>
                </div>
            </div>
            ___if(hasPermission('{{ $route }}.create'))
            <a href="__[ route('{{ $route }}.create') ]__" class="btn btn-primary">
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

    </div>
</div>
___endsection
