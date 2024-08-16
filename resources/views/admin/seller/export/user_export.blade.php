<div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800"></h1>
        <div class="card shadow mb-4">
            <div class="card-body">                 
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Company name</th>
                                <th>Company Types</th>
                                <th>Name</th>
                                <th>Last Name</th> 
                                <th>Job Title</th>
                                <th>Mail Address Employee</th>
                                <th>Phone</th>
                                <th>Company Email</th>
                                <th>Country</th>
                                <th>Location(City)</th>
                                <th>Active Product Categories</th>
                                <th>Package</th>
                                <th>Subscription Start</th>
                                <th>Subscription End</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $key=>$value)
                                <tr>
                                    <td>{{ $value['company_name'] }}</td> 
                                    <td>{{ $value['c_types'] }}</td> 
                                    <td>{{ $value['name'] }}</td> 
                                    <td>{{ $value['surname'] }}</td> 
                                    <td>{{ $value['position'] }}</td> 
                                    <td>{{ $value['email'] }}</td> 
                                    <td>{{ $value['phone'] }}</td> 
                                    <td>{{ $value['company_email'] }}</td> 
                                    <td>{{ $value['country_name'] }}</td> 
                                    <td>{{ $value['address'] }}</td> 
                                    <td>{{ $value['categories'] }}</td> 
                                    <td>{{ $value['pkg_name'] }}</td> 
                                    <td>{{ $value['subscription_start'] }}</td> 
                                    <td>{{ $value['subscription'] }}</td>    
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





