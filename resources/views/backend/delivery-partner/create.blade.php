@extends('backend/layout/app', ['sidebar' => false])
@section('header')
    <div class="row align-items-center">
        <div class="col-md-4 col-sm-12">
            <div class="mb-1">
                <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('deliverypartner') }}">{{ __('Delivery Partner') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:">{{ __('New') }}</a></li>
                </ol>
            </div>
            <h2 class="page-title" act-on="click">{{ __('New Delivery Partner') }}</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <div class="d-flex">
                @if (hasPermission('product'))
                    <a href="{{ route('product') }}" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="9" y1="6" x2="20" y2="6" />
                            <line x1="9" y1="12" x2="20" y2="12" />
                            <line x1="9" y1="18" x2="20" y2="18" />
                            <line x1="5" y1="6" x2="5" y2="6.01" />
                            <line x1="5" y1="12" x2="5" y2="12.01" />
                            <line x1="5" y1="18" x2="5" y2="18.01" />
                        </svg>
                        View All
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('body')
    <div class="row">
        <div class="col-lg-12">

            <div class="card px-2">
                <div class="card-body">
                    <form act-on="submit" act-request="{{ route('deliverypartner.store') }}">

                        <div class="row">


                            <div class="repeater">

                                <div class="repeater-item" data-repeater-item>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="repeater-title-box d-flex align-items-center justify-content-between">
                                                <div class="repeater-title">
                                                    {{ __('Delivery Partner') }}
                                                </div>

                                                <div class="repeater-btn">
                                                    <button type="button" data-repeater-delete class="btn btn-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                            <rect x="3" y="4" width="18" height="4" rx="2"></rect>
                                                            <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10"></path>
                                                            <line x1="10" y1="12" x2="14" y2="12"></line>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                    <div class="row">

                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Type') }}</label>
                                                <div>
                                                    <select name="type" class="form-select" required>
                                                        <option value=""></option>

                                                        <option value="temporary">Temporary</option>
                                                        <option value="permanent">Permenant</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                                                <div>
                                                    <input type="text" name="name" required class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Mobile Number') }} </label>
                                                <div>
                                                    <input type="text" name="mobile" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Address') }} </label>
                                                <div>
                                                    <textarea class="form-control" name="address" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Age') }} </label>
                                                <div>
                                                    <input type="text" name="age" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">


                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Driving Licence Number') }} <span class="text-danger">*</span></label>
                                                <div>
                                                    <input type="text" name="driving_licence_number" required placeholder="" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Contact Number 1') }} <span class="text-danger">*</span></label>
                                                <div>
                                                    <input type="text" name="contact_number_1" required placeholder="Emergency Contact Number 1" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Contact Number 2') }} <span class="text-danger">*</span></label>
                                                <div>
                                                    <input type="text" name="contact_number_2" required placeholder="Emergency Contact Number 2" class="form-control">
                                                </div>
                                            </div>
                                        </div>


                                    </div>


                                </div>


                            </div>

                            <div class="col-lg-12 vendor-show-input">

                                <div class="card">
                                    <div class="card-body p-0">
                                        <div class="row">

                                            <div class="col-md-6 gf-order-delivery-dtls-out">
                                                <div class="gf-order-delivery-dtls">
                                                    <h3>Vehicle Information</h3>


                                                    <div class="form-group">
                                                        <label>{{ __('Vehicle Number') }} </label>
                                                        <div>
                                                            <input type="text" name="vehicle_number" class="form-control input-mask">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Vehicle Type') }} </label>
                                                        <div>
                                                            <input type="text" name="vehicle_type" class="form-control input-mask">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Vehicle Model') }} </label>
                                                        <div>
                                                            <input type="text" name="vehicle_model" class="form-control input-mask">
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                            <div class="col-md-6 gf-order-delivery-dtls-out">
                                                <div class="gf-order-delivery-dtls">
                                                    <h3>Upload Document </h3>
                                                    <div class="row">
                                                        {{-- <div class="col-md-6 gf-order-delivery-dtls-out">
                                                        <div class="row"> --}}
                                                        <div class="col-md-2 col-sm-12">

                                                            <div class="form-group">
                                                                <label>{{ __('Profie Image') }} </label>
                                                                <div class="parent-remove">
                                                                    <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                            <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                                        </svg>
                                                                    </a>
                                                                    <div class="custom-file">
                                                                        <input type="file" id="create-form-image" class="custom-file-input" name="profile_image" data-name="profile_image" hidden accept="image/*">
                                                                        <input type="hidden" name="remove_image" class="remove-image">

                                                                        <div class="preview">
                                                                            <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                        </div>
                                                                        <label class="custom-file-label" for="create-form-image">Choose file</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="col-md-2 col-sm-12">

                                                            <div class="form-group">
                                                                <label>{{ __('Aadhar Card') }} </label>
                                                                <div class="parent-remove">
                                                                    <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                            <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                                        </svg>
                                                                    </a>
                                                                    <div class="custom-file">
                                                                        <input type="file" id="create-form-image2" class="custom-file-input" name="aadhar_card" data-name="aadhar_card" hidden accept="image/*">
                                                                        <input type="hidden" name="remove_image" class="remove-image">

                                                                        <div class="preview">
                                                                            <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                        </div>
                                                                        <label class="custom-file-label" for="create-form-image2">Choose file</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="col-md-2 col-sm-12">
                                                            <div class="form-group">
                                                                <label>{{ __('Driving Licence') }} </label>
                                                                <div class="parent-remove">
                                                                    <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                            <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                                        </svg>
                                                                    </a>
                                                                    <div class="custom-file">

                                                                        <input type="file" id="create-form-image-3" class="custom-file-input" name="driving_licence" data-name="driving_licence" hidden accept="image/*">
                                                                        <input type="hidden" name="remove_gallery_1" class="remove-image">
                                                                        <div class="preview">
                                                                            <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                        </div>
                                                                        <label class="custom-file-label" for="create-form-image-3">Choose file</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2 col-sm-12">
                                                            <div class="form-group">
                                                                <label>{{ __('Rc') }} </label>
                                                                <div class="parent-remove">
                                                                    <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                            <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                                        </svg>
                                                                    </a>
                                                                    <div class="custom-file">
                                                                        <input type="file" id="create-form-image-4" class="custom-file-input" name="rc" data-name="gallery_image_2" hidden accept="image/*">
                                                                        <input type="hidden" name="remove_gallery_2" class="remove-image">

                                                                        <div class="preview">
                                                                            <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                        </div>
                                                                        <label class="custom-file-label" for="create-form-image-4">Choose file</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- </div>
                                                    </div> --}}


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 gf-order-delivery-dtls-out">
                                                <div class="gf-order-delivery-dtls">
                                                    <h3>Earning Criteria</h3>


                                                    <div class="form-group mt-3">
                                                        <label>{{ __('Charge Per Kilometer') }} </label>
                                                        <div>
                                                            <input type="text" name="charge_per_km" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Success Delivery Amount') }} </label>
                                                        <div>
                                                            <input type="text" name="success_delivery_amount" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Weekend Incentive') }} </label>
                                                        <div>
                                                            <input type="text" name="weekend_incentive" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">


                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Daily Incentive') }} </label>
                                                        <div>
                                                            <input type="text" name="daily_incentive" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>{{ __('Holiday Incentive') }} </label>
                                                        <div>
                                                            <input type="text" name="holiday_incentive" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">


                                                        </div>
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
                                                                    <label for="radius">Delivery Area Radius (km):</label>

                                                                    <input type="number" name="delivery_radius" id="radius" placeholder="Enter radius" class="form-control" value='5'>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="radius">Delivery Area:</label>

                                                                    <input type="text" id="search-input" class="form-control" placeholder="Enter location">
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="col-md-2">
                                                            <button id="search-button" class="btn btn-primary ms-2 mt-3">Search</button>
                                                        </div>
                                                        <div class="col-md-8 mt-3">
                                                            <p>Selected Area: <span id="selected-area"></span></p>

                                                            <p>Latitude: <span id="latitude"></span></p>
                                                            <p>Longitude: <span id="longitude"></span></p>

                                                            <input type="hidden" name="delivery_area" id="delArea">
                                                            <input type="hidden" name="delivery_latitude" id="latInput">
                                                            <input type="hidden" name="delivery_longitude" id="lngInput">
                                                        </div>
                                                    </div>


                                                    <!-- Elements to display latitude and longitude -->

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <input type="hidden" default-image="{{ asset('assets/backend/img/upload-image.png') }}" id="default-img">

                                    <div class="row mb-3">
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-footer mt-3">
                                                <button type="reset" class="btn btn-secondary">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary ms-2">
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var map = L.map('map').setView([10.8505, 76.2711], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Initialize a marker variable
        var marker = null;
        var circle = null;

        // Function to add a marker at a given latitude and longitude
        function addMarker(lat, lng, areaName, zoomLevel) {
            // Remove the existing marker if it exists
            if (marker !== null) {
                map.removeLayer(marker);
            }

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
            document.getElementById('delArea').value = areaName;
            document.getElementById('search-input').value = areaName;



            // Set the map view to the selected location and adjust the zoom level
            map.setView([lat, lng], zoomLevel);
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

        // Add a click event listener to capture latitude and longitude and add a marker
        map.on('click', function(e) {
            e.originalEvent.preventDefault();
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Perform reverse geocoding to get the area name and zoom in
            reverseGeocode(lat, lng);
        });

        // Add an event listener to draw a radius when the button is clicked
        function drawRadius() {
            var radius = parseFloat(document.getElementById('radius').value);
            var lat = parseFloat(document.getElementById('latitude').textContent);
            var lng = parseFloat(document.getElementById('longitude').textContent);

            if (!isNaN(radius) && !isNaN(lat) && !isNaN(lng)) {
                // Remove the existing circle if it exists
                if (circle !== null) {
                    map.removeLayer(circle);
                }
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
            // });
        }
        document.getElementById('search-button').addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default form submission behavior

            var location = document.getElementById('search-input').value;
            // Use Nominatim's search API to search for a place
            var searchUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${location}&limit=1`;

            fetch(searchUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        var result = data[0];
                        var resultLat = parseFloat(result.lat);
                        var resultLng = parseFloat(result.lon);

                        // Perform reverse geocoding to get the area name and zoom in
                        reverseGeocode(resultLat, resultLng);
                    } else {
                        console.error('No results found for the search location:', location);
                        // If no results are found, use a default area name and zoom in
                        addMarker(lat, lng, 'Custom Area', 12); // Adjust the zoom level as needed
                    }
                })
                .catch(error => {
                    console.error('Error fetching search results:', error);
                    // If an error occurs, use a default area name and zoom in
                    addMarker(lat, lng, 'Custom Area', 12); // Adjust the zoom level as needed
                });
        });
    </script>
@endsection
