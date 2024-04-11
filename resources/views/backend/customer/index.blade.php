@extends('backend/layout/app', ['sidebar' => false])
@section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">{{ __('Application') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('Customers') }}</a></li>
            </ol>
        </div>
        <h2 class="page-title" act-on="click">{{ __('Customers') }}</h2>
    </div>
    <div class="col-auto ms-auto d-print-none filters">
        <div class="d-flex">
            <div class="filter search">
                <div class="input-icon">
                    <form act-on="submit" action="/">
                        <input type="search" id="search" class="form-control" value="{{ $search }}" placeholder="Search {{ __('Products') }}">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="15" cy="15" r="4" /><path d="M18.5 18.5l2.5 2.5" /><path d="M4 6h16" /><path d="M4 12h4" /><path d="M4 18h4" /></svg>
                        </span>
                    </form>
                </div>
            </div>
            @if(hasPermission('customer.store'))
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
            <table act-datatable="{{ route('customer.list') }}" search="#search" class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                    <tr class="bg-transparent">
                        <th name="id" priority="1" width="8%">SL</th>
                        <th name="doj" priority="8">Date of Joining</th>
                        <th name="role_name" priority="9">Role</th>
                        <th name="name" priority="2">Name</th>
                        <th name="mobile" priority="3">Mobile Number</th>
                        <th name="email" priority="6">Email</th>
                        <th name="undelivered_orders" priority="5">Undelivered Orders</th>
                        <th name="status" priority="7">Status</th>
                        <th name="actions" priority="4" width="12%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        @if(hasPermission('customer.store'))
        <!--  create form modal  -->
        <div class="modal fixed-left fade" id="create-form" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-aside" role="document">
                <div class="modal-content fix-padding">
                    <form act-on="submit" act-request="{{ route('customer.store') }}">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ __('Add Customer') }}</h4>
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

                                {{-- <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Role') }} <span class="text-danger">*</span></label>
                                        <div>
                                            <select name="role_id" required class="form-select select2">
                                                <option disabled selected value=""></option>
                                                @foreach($roles as $role)
                                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Mobile Number') }}</label>
                                        <div>
                                            <input type="text" name="mobile" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Email') }} </label>
                                        <div>
                                            <input type="text" name="email" class="form-control input-mask" data-inputmask="'alias': 'email'">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Password') }} <span class="text-danger">*</span></label>
                                        <div>
                                            <input type="password" name="password" required  class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Status') }}  <span class="text-danger">*</span></label>
                                        <div>
                                            <select name="status" required class="form-select select2">
                                                <option value="active">Active</option>
                                                <option value="blocked">Blocked</option>
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
        @if(hasPermission('customer.edit'))
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
