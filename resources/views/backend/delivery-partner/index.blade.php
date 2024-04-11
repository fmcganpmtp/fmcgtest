@extends('backend/layout/app', ['sidebar' => false])
@section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('Delivery Partner') }}</a></li>
            </ol>
        </div>
        <h2 class="page-title" act-on="click">{{ __('Devlivery Partner') }}</h2>
    </div>
    <div class="col-auto ms-auto d-print-none">
        <div class="d-flex">
            <div class="filter search">
                <div class="input-icon">
                    <input type="text" id="search" class="form-control" value="{{ $search }}" placeholder="Search {{ __('Delivery Partner') }}">
                    <span class="input-icon-addon">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="15" cy="15" r="4" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                    </span>
                </div>
            </div>
            @if(hasPermission('deliverypartner.create'))
            <a href="{{ route('deliverypartner.create') }}" class="btn btn-primary">
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
            <form id="deliverypartner-type-filter-submit" class="mt-3">
                <div class="row align-items-center">

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label>{{ __('Type') }} <span class="text-danger">*</span></label>
                            <div>
                                <select name="deliverypartner_type" class="form-select select2" id="deliverypartner_type">
                                    <option value="">Select Status</option>
                                    <option value="temporary">Temporary</option>
                                    <option value="permanent">Permanent</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">

                        <button type="submit" class="btn btn-primary waves-effect waves-light mr-2 px-3 mt-2"id="form-filter">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
            <table act-datatable="{{ route('deliverypartner.list') }}" search="#search" class="table card-table table-vcenter text-nowrap datatable" id="dtable">
                <thead>
                    <tr class="bg-transparent">
                        <th name="id" priority="1" width="8%">SL</th>
                        <th name="type" priority="2" width="8%">Type</th>
                        <th name="name" priority="3">Name</th>
                        <th name="mobile" priority="4">Mobile</th>
                        <th name="vehicle_number" priority="5">Vehicle Number</th>
                        <th name="online_status" priority="6">Online/Offline</th>


                        <th name="status" priority="7">Status</th>

                        <th name="actions" priority="8" width="12%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(function() {

            let table = $('#dtable');

            table.on('preXhr.dt', function(e, settings, data) {
                data.filter = {
                    deliverypartner_type: $('#deliverypartner_type').val(),
                }
            });
            $('#deliverypartner-type-filter-submit').submit(function(e) {
                e.preventDefault();
                table.DataTable().draw();
            });


        });
        </script>
        @endsection
