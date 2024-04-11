@extends('backend/layout/app', ['sidebar' => false])
@section('header')
<div class="row align-items-center">
    <div class="col-md-4 col-sm-12">
        <div class="mb-1">
            <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('Coupons') }}</a></li>
            </ol>
        </div>
        <h2 class="page-title" act-on="click">{{ __('Coupons') }}</h2>
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
            @if(hasPermission('coupon.store'))
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-form">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                {{ __('Add New') }}
            </a>
            @endif
        </div>
    </div>

    <form id="filter-submit" class="mt-3">
        <div class="row align-items-center">

            <div class="col-sm-3">
                <div class="form-group">
                    <label>{{ __('Coupon Status') }} <span class="text-danger">*</span></label>
                    <div>
                        <select name="coupon_status"  class="form-select select2" id="status_filter">
                            <option value="">Select Status</option>

                            <option value="draft">Draft</option>
                            <option value="private">Private</option>
                            <option value="published">Published</option>
                            <option value="expired">Expired</option>
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
</div>
@endsection
@section('body')
<div class="row">
    <div class="col-lg-12">
         <div class="table-responsive">
            <table act-datatable="{{ route('coupon.list') }}" search="#search" class="table card-table table-vcenter text-nowrap datatable">
            <thead>
                    <tr class="bg-transparent">
                        <th name="id" priority="1" width="8%">SL</th>
                        <th name="title">Title</th>
                        <th name="vendor_name">vendor</th>

                        <th name="code">Code</th>
                        <th name="status">Status</th>
                        <th name="actions" priority="7" width="12%">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        @if(hasPermission('coupon.store'))
        <!--  create form modal  -->
        <div class="modal fixed-left fade" id="create-form" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-aside" role="document">
                <div class="modal-content fix-padding">
                    <form act-on="submit" act-request="{{ route('coupon.store') }}">
                        <div class="modal-header">
                            <h4 class="modal-title">{{ __('Add Coupon') }}</h4>
                                </div>
                                <div class="modal-body">
                            <div class="row">

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Title') }}  <span class="text-danger">*</span></label>
                                        <div>
                                            <input type="text" name="title"  required   class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Vendor') }}</label>
                                        <div>
                                            <select name="vendor_id"  class="form-select select2">
                                                <option selected value="">Select Vendor</option>
                                                @foreach($vendors as $vendor)
                                                    <option value="{{$vendor->id}}">{{ucfirst($vendor->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Description') }} </label>
                                        <div>
                                            <input type="text" name="description"   class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('T&C') }} </label>
                                        <div>
                                            <textarea name="tc" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Code') }}  <span class="text-danger">*</span></label>
                                        <div>
                                            <input type="text" name="code"  required   class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Min Cart Amount') }} </label>
                                        <div>
                                            <input type="text" name="min_cart_amount"   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Max Cart Amount') }} </label>
                                        <div>
                                            <input type="text" name="max_cart_amount"   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('On Which Order') }}  <span class="text-danger">*</span></label>
                                        <div>
                                            <input type="text" name="on_which_order"  required   class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Discount Amount') }}  <span class="text-danger">*</span></label>
                                        <div>
                                            <input type="text" name="discount_amount"  required   class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                    <label>{{ __('Status') }}  <span class="text-danger">*</span></label>
                                        <div>
                                            <select name="status" required class="form-select select2">
                                                <option value="draft">Draft</option>
                                                <option value="private">Private</option>
                                                <option value="published">Published</option>
                                                <option value="expired">Expired</option>
                                                {{-- <option value="deleted">Deleted</option> --}}

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
        @if(hasPermission('coupon.edit'))
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
@section('script')
    <script>
        $(function() {

            let table = $('.datatable');
            table.on('preXhr.dt', function(e, settings, data) {
                data.filter = {
                    coupon_status:$('#status_filter').val()


                }
            });
            $('#filter-submit').submit(function(e) {
                e.preventDefault();
                table.DataTable().draw();
            });
        });
    </script>
@endsection
