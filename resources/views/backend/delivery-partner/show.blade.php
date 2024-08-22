@extends('backend/layout/app', ['sidebar' => false])
@section('header')
    <div class="row align-items-center">
        <div class="col-md-4 col-sm-12">
            <div class="mb-1">
                <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('deliverypartner') }}">{{ __('Delivery partner') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('show') }}</a></li>
                </ol>
            </div>
            <h2 class="page-title" act-on="click">{{ __('DeliveryPartner Details') }}</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
                @if (hasPermission('deliverypartner'))
                    <a href="{{ route('deliverypartner') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="9" y1="6" x2="20" y2="6" />
                            <line x1="9" y1="12" x2="20" y2="12" />
                            <line x1="9" y1="18" x2="20" y2="18" />
                            <line x1="5" y1="6" x2="5" y2="6.01" />
                            <line x1="5" y1="12" x2="5" y2="12.01" />
                            <line x1="5" y1="18" x2="5" y2="18.01" />
                        </svg>
                        {{ __('View All') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('body')
    {{-- <div class="row"> --}}
    <div class="col-lg-12 vendor-show-input">

        <div class="card px-2">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3>Profile Details</h3>
                            <div class="form-group">
                                <label><span>{{ __('DP-Type') }}</span> : {{ ucfirst($deliverypartner->type) }}</label>

                                <label><span>{{ __('Name') }}</span> : {{ $deliverypartner->name }}</label>
                                <label><span>{{ __('Mobile Number') }}</span> : {{ $deliverypartner->mobile }}</label>
                                <label><span>{{ __('Address') }}</span> : {{ $deliverypartner->address }}</label>
                                <label><span>{{ __('Age') }}</span> : {{ $deliverypartner->age }}</label>
                                <label><span>{{ __('Driving Licence Number') }}</span> : {{ $deliverypartner->driving_licence_number }}</label>
                                <label><span>{{ __('Contact Number 1') }}</span> : {{ $deliverypartner->contact_number_1 }}</label>
                                <label><span>{{ __('Contact Number 1') }}</span> : {{ $deliverypartner->contact_number_2 }}</label>
                                <label><span>{{ __('Status') }}</span> : {{ ucfirst($deliverypartner->status) }}</label>
                                <label><span>{{ __('Online/Offline') }}</span> : {{ $deliverypartner->online == 1 ? 'Online' : 'Offline' }}</label>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3>Vehicle Information</h3>
                            <div class="form-group">
                                <label><span>{{ __('Vehicle Number') }}</span> : {{ $deliverypartner->vehicle_number }}</label>
                                <label><span>{{ __('Vehicle Type') }}</span> : {{ $deliverypartner->vehicle_type }}</label>
                                <label><span>{{ __('Vehicle Model') }}</span> : {{ $deliverypartner->vehicle_model }}</label>

                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" style="max-width: 800px;"> <!-- Adjust the width as needed -->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">File Preview</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- iframe to display the file -->
                                    <iframe id="filePreviewFrame" width="100%" height="400" frameborder="0"></iframe>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3> Uploaded Documents</h3>
                            <div class="form-group">
                                <div id="filePreviewModal" class="modal">
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <iframe id="filePreviewFrame" src="" frameborder="0"></iframe>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-2 col-sm-12">

                                        <div class="form-group  mt-3">
                                            <label>{{ __('Profile Image') }} </label>

                                            <div class="custom-file">
                                                <div class="preview">
                                                    @if ($deliverypartner->profile_image == '')
                                                        <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                    @else
                                                        <img src="{{ asset('uploads/' . $deliverypartner->profile_image) }}" class="custom-file-preview view-file-button" data-url="{{ asset('uploads/' . $deliverypartner->profile_image) }}" data-type="file" />
                                                    @endif
                                                </div>
                                                {{-- <label class="custom-file-label" for="create-form-image">Choose file</label> --}}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-2 col-sm-12">

                                        <div class="form-group mt-3">
                                            <label>{{ __('Aadhar Card') }} </label>

                                            <div class="custom-file">

                                                <div class="preview">
                                                    @if ($deliverypartner->aadhar_card == '')
                                                        <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                    @else
                                                        @php
                                                            $fileExtension = pathinfo($deliverypartner->aadhar_card, PATHINFO_EXTENSION);
                                                        @endphp
                                                        @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img default-src="{{ asset('assets/backend/img/document-default.png') }}" src="{{ asset('uploads/' . $deliverypartner->aadhar_card) }}" class="custom-file-preview view-file-button" data-url="{{ asset('uploads/' . $deliverypartner->aadhar_card) }}" data-type="file" />
                                                        @else
                                                            <!-- Display a document icon or other representation for non-image files -->
                                                            <span class="document-icon"> <img src="{{ asset('assets/backend/img/document-default.png') }}" class="custom-file-preview view-file-button" data-url="{{ asset('uploads/' . $deliverypartner->aadhar_card) }}" data-type="file" /></span>
                                                        @endif
                                                    @endif
                                                </div>


                                                {{-- <div class="preview">
                                                    @if ($deliverypartner->aadhar_card == '')
                                                        <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                    @else
                                                        <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $deliverypartner->aadhar_card) }}" class="custom-file-preview" />
                                                    @endif
                                                </div> --}}
                                                {{-- <label class="custom-file-label" for="create-form-image2">Choose file</label> --}}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-2 col-sm-12">

                                        <div class="form-group mt-3">
                                            <label>{{ __('Driving Licence') }} </label>

                                            <div class="custom-file">
                                                <div class="preview">
                                                    @if ($deliverypartner->driving_licence == '')
                                                        <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                    @else
                                                        @php
                                                            $fileExtension = pathinfo($deliverypartner->driving_licence, PATHINFO_EXTENSION);
                                                        @endphp
                                                        @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img src="{{ asset('uploads/' . $deliverypartner->driving_licence) }}" class="custom-file-preview view-file-button" data-url="{{ asset('uploads/' . $deliverypartner->driving_licence) }}" data-type="file" />
                                                        @else
                                                            <!-- Display a document icon or other representation for non-image files -->
                                                            <span class="document-icon"> <img src="{{ asset('assets/backend/img/document-default.png') }}" class="custom-file-preview view-file-button" data-url="{{ asset('uploads/' . $deliverypartner->driving_licence) }}" data-type="file" /></span>
                                                        @endif
                                                    @endif
                                                </div>

                                                {{-- <div class="preview">
                                                    @if ($deliverypartner->driving_licence == '')
                                                        <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                    @else
                                                        <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $deliverypartner->driving_licence) }}" class="custom-file-preview" />
                                                    @endif
                                                </div> --}}
                                                {{-- <label class="custom-file-label" for="create-form-image3">Choose file</label> --}}
                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-2 col-sm-12">

                                        <div class="form-group mt-3">
                                            <label>{{ __('RC') }} </label>

                                            <div class="custom-file">
                                                <div class="preview">
                                                    @if ($deliverypartner->rc == '')
                                                        <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                    @else
                                                        @php
                                                            $fileExtension = pathinfo($deliverypartner->rc, PATHINFO_EXTENSION);
                                                        @endphp
                                                        @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img default-src="{{ asset('assets/backend/img/document-default.png') }}" src="{{ asset('uploads/' . $deliverypartner->rc) }}" class="custom-file-preview view-file-button" data-url="{{ asset('uploads/' . $deliverypartner->rc) }}" data-type="file" />
                                                        @else
                                                            <!-- Display a document icon or other representation for non-image files -->
                                                            <span class="document-icon"> <img src="{{ asset('assets/backend/img/document-default.png') }}" class="custom-file-preview view-file-button" data-url="{{ asset('uploads/' . $deliverypartner->rc) }}" data-type="file" /></span>
                                                        @endif
                                                    @endif
                                                </div>
                                                {{--

                                                    <div class="preview">
                                                        @if ($deliverypartner->rc == '')
                                                            <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                        @else
                                                            <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $deliverypartner->rc) }}" class="custom-file-preview" />
                                                        @endif
                                                    </div> --}}
                                                {{-- <label class="custom-file-label" for="create-form-image4">Choose file</label> --}}
                                            </div>
                                        </div>

                                    </div>


                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3>Earning Critiria</h3>


                            <div class="form-group">
                                <label><span>{{ __('Charge Per Kilometer') }}</span> : {{ $deliverypartner->charge_per_km }}</label>
                                <label><span>{{ __('Success Delivery Amount') }}</span> : {{ $deliverypartner->success_delivery_amount }}</label>
                                <label><span>{{ __('Weekend Incentive') }}</span> : {{ $deliverypartner->weekend_incentive }}</label>
                                <label><span>{{ __('Daily Incentive') }}</span> : {{ $deliverypartner->daily_incentive }}</label>
                                <label><span>{{ __('Holiday Incentive') }}</span> : {{ $deliverypartner->holiday_incentive }}</label>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 gf-order-delivery-dtls-out">
                        <div class="gf-order-delivery-dtls">
                            <h3>Delivery Zone</h3>



                            <div id="map" style="height: 450px;"></div>

                            <!-- Search input and button -->
                            <div class="row mt-3">
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{-- <label for="radius">Delivery Area Radius (km):</label> --}}

                                            <input type="hidden" id="radius" name="delivery_radius" placeholder="Enter radius" class="form-control" value="{{ $deliverypartner->delivery_radius }}">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" id="search-input" name="delivery_area" class="form-control" placeholder="Enter location" value="{{ $deliverypartner->delivery_area }}">
                                        </div>
                                    </div>


                                </div>
                                {{-- <div class="col-md-2">
                                    <button id="search-button" class="btn btn-primary ms-2 mt-3">Search</button>
                                </div> --}}
                                <div class="col-md-8 mt-3">
                                    <p>Delivery Area Radius (km): <span id="delivery-radius">{{ $deliverypartner->delivery_radius }} KM</span></p>

                                    <p>Selected Area: <span id="selected-area">{{ $deliverypartner->delivery_area }}</span></p>

                                    <p>Latitude: <span id="latitude">{{ $deliverypartner->delivery_latitude }}</span></p>
                                    <p>Longitude: <span id="longitude">{{ $deliverypartner->delivery_longitude }}</span></p>

                                    <input type="hidden" name="delivery_latitude" id="latInput">
                                    <input type="hidden" name="delivery_longitude" id="lngInput">
                                </div>
                            </div>


                            <!-- Elements to display latitude and longitude -->

                        </div>
                    </div>

                    <div class="col-md-6 gf-order-delivery-dtls-out">



                        <div class="modal fade" id="assignvendorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="max-width: 500px;"> <!-- Adjust the width as needed -->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="assignvendorModalLabel">Select Vendor</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body vendor-assign-out">
                                        <div class="form-group">
                                            <form act-on="submit" act-request="{{ route('dpvendor.assign', ['deliverypartner' => $deliverypartner->id]) }}">

                                                <div data-repeater-list="vendor">
                                                    <select class="selectpicker vendor-assign-select" name="assign_vendor[]" multiple aria-label="size 3 select example" required>
                                                        @foreach ($unassignedvendors as $row)
                                                            <option value="{{ $row->id }}">{{ ucfirst($row->name) }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Assign</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>



                        <div class="gf-order-delivery-dtls">
                            <div class="assignvendor-outer">
                            <h3>Assigned Vendors</h3>
                            <button class="btn btn-primary" type="button" data-bs-target="#assignvendorModal" data-bs-toggle="modal">
                                <svg xmlns="http://www.w3.org/2000/svg"class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="11" fill="none" stroke="#000" stroke-width="2" />
                                    <line x1="12" y1="7" x2="12" y2="17" stroke="#000" stroke-width="2" />
                                    <line x1="7" y1="12" x2="17" y2="12" stroke="#000" stroke-width="2" />
                                </svg>
                                {{ __('Assign Vendor') }}
                            </button>
                            </div>
                            <table act-datatable="{{ route('assigned.vendor.list', ['deliverypartner' => $deliverypartner->id]) }}" search="#search" class="table card-table table-vcenter text-nowrap datatable" id="dtable">
                                <thead>
                                    <tr class="bg-transparent">
                                        <th name="id" priority="1" width="8%">SL</th>
                                        <th name="name" priority="2">Name</th>
                                        <th name="location" priority="3">Location</th>
                                        <th name="contact" priority="4">Contact Number</th>



                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>

                            <!-- Elements to display latitude and longitude -->

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>



    {{-- </div> --}}
@endsection
@section('script')
    <script>
        var map = L.map('map').setView([10.8505, 76.2711], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Initialize a marker and circle variables
        var marker = null;
        var circle = null;

        // Function to add a marker at a given latitude and longitude
        function addMarker(lat, lng, areaName, zoomLevel) {
            // Clear the existing marker and circle
            clearMarkerAndCircle();

            // Create a marker and add it to the map
            marker = L.marker([lat, lng]).addTo(map);

            // Update the latitude and longitude elements on the page
            document.getElementById('latitude').textContent = lat;
            document.getElementById('longitude').textContent = lng;

            // Update the selected area name on the page
            document.getElementById('selected-area').textContent = areaName;

            // You can also store these values in hidden input fields for form submission
            document.getElementById('latInput').value = lat;
            document.getElementById('lngInput').value = lng;
            document.getElementById('search-input').value = areaName;

            // Set the map view to the selected location and adjust the zoom level
            map.setView([lat, lng], zoomLevel);
        }

        // Function to draw a radius circle
        function drawRadius() {
            var radius = parseFloat(document.getElementById('radius').value);
            var lat = parseFloat(document.getElementById('latitude').textContent);
            var lng = parseFloat(document.getElementById('longitude').textContent);

            if (!isNaN(radius) && !isNaN(lat) && !isNaN(lng)) {
                // Remove the existing circle if it exists
                clearCircle();

                // Create a circle and add it to the map
                circle = L.circle([lat, lng], {
                    color: 'green',
                    fillColor: 'green',
                    fillOpacity: 0.2,
                    radius: radius * 1000 // Convert km to meters
                }).addTo(map);
            } else {
                alert('Please enter a valid radius and select a location on the map.');
            }
        }

        // Function to clear the marker and circle
        function clearMarkerAndCircle() {
            if (marker !== null) {
                map.removeLayer(marker);
                marker = null;
            }

            clearCircle();
        }

        // Function to clear the circle
        function clearCircle() {
            if (circle !== null) {
                map.removeLayer(circle);
                circle = null;
            }
        }

        // Function to perform reverse geocoding and get the area name
        function reverseGeocode(lat, lng) {
            // Construct the Nominatim reverse geocoding URL
            var nominatimUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`;

            // Send a GET request to Nominatim API
            fetch(nominatimUrl)
                .then(response => response.json())
                .then(data => {
                    // Extract the area name from the response (you can customize this based on your needs)
                    var areaName = data.display_name || 'Custom Area';

                    // Add a marker at the clicked location with the area name and zoom in
                    addMarker(lat, lng, areaName, 10); // Adjust the zoom level as needed
                    drawRadius();
                })
                .catch(error => {
                    console.error('Error fetching reverse geocoding data:', error);
                    // If an error occurs, use a default area name and zoom in
                    addMarker(lat, lng, 'Custom Area', 5); // Adjust the zoom level as needed
                });
        }



        // Load initial data and display marker and circle
        var initialLat = parseFloat("{{ $deliverypartner->delivery_latitude }}");
        var initialLng = parseFloat("{{ $deliverypartner->delivery_longitude }}");
        var initialArea = "{{ $deliverypartner->delivery_area }}";
        var initialRadius = parseFloat("{{ $deliverypartner->delivery_radius }}");

        if (!isNaN(initialLat) && !isNaN(initialLng)) {
            addMarker(initialLat, initialLng, initialArea, 10);
        }

        if (!isNaN(initialLat) && !isNaN(initialLng) && !isNaN(initialRadius)) {
            drawRadius();
        }
    </script>
@endsection
