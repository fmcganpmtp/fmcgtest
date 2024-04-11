@extends('backend/layout/app', ['sidebar' => false])
@section('header')
    <div class="row align-items-center">
        <div class="col-md-4 col-sm-12">
            <div class="mb-1">
                <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('Orders') }}</a></li>
                </ol>
            </div>
            <h2 class="page-title" act-on="click">{{ __('Orders') }}</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
                <div class="filter search">
                    <div class="input-icon">
                        <input type="text" id="search" class="form-control" value="{{ $search }}" placeholder="Search {{ __('Orders') }}">
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
        <form id="filter-submit" class="mt-3">
            <div class="row align-items-center">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>{{ __('Order Status') }} <span class="text-danger">*</span></label>
                        <div>
                            <select name="order_status" id="order_filter" class="form-select select2">
                                <option value="">Select Status</option>

                                <option value="ordered">Ordered</option>
                                <option value="placed">Placed</option>
                                <option value="prepared">Prepared</option>
                                <option value="picked">Picked</option>
                                <option value="delivered">Delivered</option>
                                <option value="returned">Returned</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="undeliverd">Undelivered</option>
                                <option value="expired">Expired </option>


                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label>{{ __('Payment Status') }} <span class="text-danger">*</span></label>
                        <div>
                            <select name="payment_status" class="form-select select2" id="payment_filter">
                                <option value="">Select Status</option>

                                <option value="success">Success</option>
                                <option value="pending">Pending</option>

                                <option value="failed">Failed</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">


                        <label>{{ __('Date From:') }} <span class="text-danger"></span></label>

                        <input type="date" id="date-from" class="form-control" name="date_from" placeholder="" max="{{ now()->toDateString('Y-m-d') }}" value="{{ request()->get('date_from') != null ? date('Y-m-d', strtotime(request()->get('date_from'))) : '' }}">
                    </div>
                </div>

                <div class="col-xs-2 col-sm-2 col-md-2">
                    <div class="form-group">

                        <label>{{ __('Date To:') }} <span class="text-danger"></span></label>
                        <input type="date" id="date-to" class="form-control" name="date_to" placeholder="" max="{{ now()->toDateString('Y-m-d') }}" value="{{ request()->get('date_to') != null ? date('Y-m-d', strtotime(request()->get('date_to'))) : '' }}">
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
                <table act-datatable="{{ route('order.list') }}" search="#search" order_status="placed" class="table card-table table-vcenter text-nowrap datatable"id="dtable">
                    <thead>
                        <tr class="bg-transparent">
                            <th name="id" priority="1" width="8%">SL</th>
                            <th name="order_id">Order ID</th>
                            <th name="date_time">Date and Time</th>
                            <th name="user_name">Customer Name</th>
                            <th name="user_id">Customer ID</th>
                            <th name="final_amount">Order Amount</th>
                            <th name="vendor_name">Vendor Name</th>
                            <th name="vendor_location">Vendor Location</th>
                            <th name="status">Status</th>
                            <th name="payment_status">Payment Status</th>
                            <th name="actions" priority="7" width="12%">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>


                </table>
                <div id="modal-status" class="modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-sm">
                        <div class="modal-content">
                            <form id="form-change-status" method="POST" act-on="submit" act-request="">
                                @csrf
                                <div class="modal-header" style="padding: 0 1.5rem 0 1.5rem">
                                    <h4 class="modal-title">STATUS</h4>
                                    <button type="button" class="close" onclick="closeModal()" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option disabled>Status</option>
                                                    <option value="ordered">Ordered</option>
                                                    <option value="placed">Placed</option>
                                                    <option value="prepared">Prepared</option>
                                                    <option value="picked">Picked</option>
                                                    <option value="delivered">Delivered</option>
                                                    <option value="returned">Returned</option>
                                                    <option value="cancelled">Cancelled</option>
                                                    <option value="undeliverd">Undelivered</option>
                                                    <option value="expired">Expired </option>
                                                </select>
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
                    order_status: $('#order_filter').val(),
                    payment_status: $('#payment_filter').val(),
                    date_from: $('#date-from').val(),
                    date_to: $('#date-to').val(),
                }
            });
            $('#filter-submit').submit(function(e) {
                console.log(table);
                e.preventDefault();
                table.DataTable().draw();
            });

            $('#date-to').on('change', function() {
                var startDate = new Date($('#date-from').val());
                var endDate = new Date($('#date-to').val());

                if (endDate.getTime() < startDate.getTime()) {
                    alert('End date should be greater than Start date.');
                    $('#date-to').val('');
                }
            });
            $('#date-from').on('change', function() {
                var startDate = new Date($('#date-from').val());
                var endDate = new Date($('#date-to').val());

                if (endDate.getTime() < startDate.getTime()) {
                    alert('Start date should be less than End date.');
                    $('#date-from').val('');
                }
            });

            // setInterval(function() {
            //     $('#dtable').DataTable().ajax.reload(null, false);
            // }, 1000);


            // setInterval(() => {
            //     updateTimeIntervel()
            // }, 1000);

        });
        $(document).on('click', '.button-change-status', function(e) {
            e.preventDefault();
            let url = $(this).data('url');
            let status = $(this).data('status');

            $('#form-change-status').attr('act-request', url);
            $('#status').val(status);
            $('#modal-status').modal('toggle');
        });
        // Function to close the modal
        function closeModal() {
            $('#modal-status').modal('hide');
        }


        // function updateTimeIntervel() {
        //     $.ajax({
        //         url: 'your_update_status_url', // Replace with the actual URL to retrieve the updated status details
        //         type: 'GET', // Replace with the appropriate HTTP method
        //         success: function(response) {
        //             // Assuming the response contains the updated status content
        //             var updatedStatus = response.status;

        //             // Update the status content of the table row
        //             $('.status-row td[name="status"]').text(updatedStatus);
        //         },
        //         error: function() {
        //             // Handle the error case if the AJAX request fails
        //             console.error('Failed to retrieve updated status details.');
        //         }
        //     });

        // }
    </script>
@endsection
