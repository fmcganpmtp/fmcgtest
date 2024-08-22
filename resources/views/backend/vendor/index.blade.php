@extends('backend/layout/app', ['sidebar' => false])
@section('header')
    <div class="row align-items-center">
        <div class="col-md-4 col-sm-12">
            <div class="mb-1">
                <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('Vendors') }}</a></li>
                </ol>
            </div>
            <h2 class="page-title" act-on="click">{{ __('Vendors') }}</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
                <div class="filter search">
                    <div class="input-icon">
                        <input type="text" id="search" class="form-control" value="{{ $search }}" placeholder="Search {{ __('Vendors') }}">
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <circle cx="15" cy="15" r="4" />
                                <path d="M18.5 18.5l2.5 2.5" />
                                <path d="M4 6h16" />
                                <path d="M4 12h4" />
                                <path d="M4 18h4" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <form id="vendor-filter-submit" class="mt-3">
            <div class="row align-items-center">

                <div class="col-sm-2">
                    <div class="form-group">
                        <label>{{ __('Payment Status') }} <span class="text-danger">*</span></label>
                        <div>
                            <select name="vendor_status" class="form-select select2" id="vendor_filter">
                                <option value="">Select Status</option>

                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
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
                <table act-datatable="{{ route('vendor.list') }}" search="#search" class="table card-table table-vcenter text-nowrap datatable" id="dtable">
                    <thead>
                        <tr class="bg-transparent">
                            <th name="id" priority="1" width="8%">SL</th>
                            <th name="name">Name</th>
                            <th name="gst_number">Gst Number</th>
                            <th name="location">Location</th>
                            <th name="state">State</th>
                            <th name="district">District</th>
                            <th name="contact_person">Contact Person</th>
                            <th name="primary_contact_number">Contact Number</th>
                            <th name="doa">Date of activation</th>
                            <th name="tdo" priority="5">Total Delivered Orders</th>
                            <th name="status">Status</th>
                            <th name="vendor_type">Vendor Type</th>

                            <th name="actions" priority="7" width="12%">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modal-commission-percent" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <form id="form-update-commission" method="POST" act-on="submit" act-request="">
                    @csrf
                    <div class="modal-header" style="padding: 0 1.5rem 0 1.5rem">
                        <h4 class="modal-title">Commission Percentage</h4>
                        <button type="button" class="close-commission-modal" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Commission Percentage(%)</label>
                                    <input type="number"name="commission_percentage" id="percent"class="form-control" max="100" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </div>
                </form>
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
                    vendor_status: $('#vendor_filter').val(),
                }
            });
            $('#vendor-filter-submit').submit(function(e) {
                e.preventDefault();
                table.DataTable().draw();
            });
            $(document).on('click', '.button-update-commission', function(e) {
                e.preventDefault();
                let url = $(this).data('url');
                let percent = $(this).data('percent');
                $('#form-update-commission').attr('act-request', url);
                $('#percent').val(percent);
                $('#modal-commission-percent').modal('toggle');
            });
            // Function to close the modal
            $(document).on('click', '.close-commission-modal', function(e) {
                $('#modal-commission-percent').modal('hide');
            });

        });
        $(document).on('click', '.button-make-vendor', function(e) {
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');
            var url = "{{ route('vendor.type.update', ['vendor' => ':id']) }}";
            var csrfToken = '{{ csrf_token() }}';

            url = url.replace(':id', id);
            Swal.fire({
                title: 'Are you sure?',
                text: $(this).attr('act-confirm'),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#663259',
                cancelButtonColor: '#f64e60',
                confirmButtonText: 'Yes, Proceed'
            }).then(function(result) {
                if (result.isConfirmed) {
                    let table = $('#dtable');


                    $.ajax({
                        url: url,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            'type': type
                        },
                        success: function(response) {

                            Swal.fire({
                                icon: response.alert.icon,
                                title: response.alert.title,
                                text: response.alert.text,
                                timer: 2000,
                                timerProgressBar: true, // Display a progress bar indicating the remaining time
                                showConfirmButton: false, // Hide the default "OK" button
                            });
                            table.DataTable().draw();

                        },
                        error: function(xhr, status, error) {
                            // Handle any errors
                        }
                    });
                }
            });

        });
    </script>
@endsection
