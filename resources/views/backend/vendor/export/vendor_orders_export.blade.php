
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800"></h1>
        <div class="card shadow mb-4">
            <div class="card-body">

                <button type="submit" class="btn btn-primary" id="btnExport">Export</button>
                <div class="table-responsive">

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date Time</th>
                                <th>Customer Name</th>
                                <th>Grand Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ordersList as $key=>$value)
                                <tr>

                                    {{-- <td>{{ $key + $ordersList->firstItem() }}</td> --}}
                                    <td>{{ $value->order_id }}</td>
                                    <td>{{ $value->date_time }}</td>
                                    <td> {{ $value->user_name }}</td>
                                    <td>Rs {{ $value->final_amount }}</td>
                                    <td>{{  ucwords($value->status) }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="text-center text-danger">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>





