@extends('backend/layout/app', ['sidebar' => false])
@section('header')
    <div class="row align-items-center">
        <div class="col-md-4 col-sm-12">
            <div class="mb-1">
                <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('deliverypartner') }}">{{ __('Delivery Partner') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:">{{ __('Edit') }}</a></li>
                </ol>
            </div>
            <h2 class="page-title" act-on="click">{{ __('Edit Delivery Partner') }}</h2>
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
                    <form act-on="submit" act-request="{{ route('deliverypartner.update', ['deliverypartner' => $deliverypartner->id]) }}">

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

                                                        <option value="temporary" {{ $deliverypartner->type == 'temporary' ? 'selected' : '' }}>Temporary</option>
                                                        <option value="permanent" {{ $deliverypartner->type == 'permanent' ? 'selected' : '' }}>Permenant</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                                                <div>
                                                    <input type="text" name="name" required class="form-control" value="{{ $deliverypartner->name }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Mobile Number') }} </label>
                                                <div>
                                                    <input type="text" name="mobile" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false" value="{{ $deliverypartner->mobile }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Address') }} </label>
                                                <div>
                                                    <textarea class="form-control" name="address" rows="4">{{ $deliverypartner->address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Age') }} </label>
                                                <div>
                                                    <input type="text" name="age" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false" value="{{ $deliverypartner->age }}">


                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Driving Licence Number') }} <span class="text-danger">*</span></label>
                                                <div>
                                                    <input type="text" name="driving_licence_number" required placeholder="" class="form-control" value="{{ $deliverypartner->driving_licence_number }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Contact Number 1') }} <span class="text-danger">*</span></label>
                                                <div>
                                                    <input type="text" name="contact_number_1" required placeholder="Emergency Contact Number 1" class="form-control" value="{{ $deliverypartner->contact_number_1 }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group">
                                                <label>{{ __('Contact Number 2') }} <span class="text-danger">*</span></label>
                                                <div>
                                                    <input type="text" name="contact_number_2" required placeholder="Emergency Contact Number 2" class="form-control" value="{{ $deliverypartner->contact_number_2 }}">
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
                                                            <input type="text" name="vehicle_number" class="form-control input-mask" value="{{ $deliverypartner->vehicle_number }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Vehicle Type') }} </label>
                                                        <div>
                                                            <input type="text" name="vehicle_type" class="form-control input-mask" value="{{ $deliverypartner->vehicle_type }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Vehicle Model') }} </label>
                                                        <div>
                                                            <input type="text" name="vehicle_model" class="form-control input-mask" value="{{ $deliverypartner->vehicle_model }}">
                                                        </div>
                                                    </div>



                                                </div>
                                            </div>
                                            <div class="col-md-6 gf-order-delivery-dtls-out">
                                                <div class="gf-order-delivery-dtls">
                                                    <h3>Upload Document </h3>
                                                    <div class="row">
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
                                                        <div class="col-md-2 col-sm-12">

                                                            <div class="form-group">
                                                                <label>{{ __('Profile Image') }} </label>
                                                                <div class="parent-remove">
                                                                    <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                            <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                                        </svg>
                                                                    </a>
                                                                    <div class="custom-file">
                                                                        <input type="file" id="create-form-image" class="custom-file-input" name="profile_image" data-name="profile_image" hidden accept="image/*">
                                                                        <input type="hidden" name="remove_profile_image" class="remove-image">

                                                                        <div class="preview">
                                                                            @if ($deliverypartner->profile_image == '')
                                                                                <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                            @else
                                                                                <div><img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $deliverypartner->profile_image) }}" class="custom-file-preview" /> </div>
                                                                            @endif
                                                                        </div>
                                                                        <label class="custom-file-label" for="create-form-image">Choose file</label>

                                                                    </div>
                                                                    @if ($deliverypartner->profile_image != '')
                                                                    <div><a href="javascript:void(0);" class="custom-file-preview view-file-button mt-3" data-url="{{ asset('uploads/' . $deliverypartner->profile_image) }}" data-type="file">Show</a> </div>
                                                                    @endif


                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-2 col-sm-12">

                                                            <div class="form-group">
                                                                <label>{{ __('Aadhar Card') }}</label>
                                                                <div class="parent-remove">
                                                                    <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                            <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                                        </svg>
                                                                    </a>
                                                                    <div class="custom-file">
                                                                        <input type="file" id="create-form-image2" class="custom-file-input" name="aadhar_card" data-name="aadhar_card" hidden accept=".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx, application/msword">
                                                                        <input type="hidden" name="remove_aadhar_card" class="remove-image">

                                                                        <div class="preview">
                                                                            @if ($deliverypartner->aadhar_card == '')
                                                                                <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                            @else
                                                                                @php
                                                                                    $fileExtension = pathinfo($deliverypartner->aadhar_card, PATHINFO_EXTENSION);
                                                                                @endphp
                                                                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                                    <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $deliverypartner->aadhar_card) }}" class="custom-file-preview" />
                                                                                @else
                                                                                    <!-- Display a document icon or other representation for non-image files -->
                                                                                    <span class="document-icon"><img src="{{ asset('assets/backend/img/document-default.png') }}" class="custom-file-preview" /></span>
                                                                                @endif
                                                                            @endif
                                                                        </div>


                                                                        <label class="custom-file-label" for="create-form-image2">Choose file</label>


                                                                    </div>
                                                                    @if ($deliverypartner->aadhar_card != '')
                                                                    <div><a href="javascript:void(0);" class="custom-file-preview view-file-button mt-3" data-url="{{ asset('uploads/' . $deliverypartner->aadhar_card) }}" data-type="file">Show</a> </div>
                                                                    @endif
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
                                                                        <input type="file" id="create-form-image3" class="custom-file-input" name="driving_licence" data-name="driving_licence" hidden accept=".jpg, .jpeg, .png,.pdf, .doc, .docx, application/msword">
                                                                        <input type="hidden" name="remove_driving_licence" class="remove-image">

                                                                        <div class="preview">
                                                                            @if ($deliverypartner->driving_licence == '')
                                                                                <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                            @else
                                                                                @php
                                                                                    $fileExtension = pathinfo($deliverypartner->driving_licence, PATHINFO_EXTENSION);
                                                                                @endphp
                                                                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                                    <img default-src="{{ asset('assets/backend/img/document-default.png') }}" src="{{ asset('uploads/' . $deliverypartner->aadhar_card) }}" class="custom-file-preview" />
                                                                                @else
                                                                                    <!-- Display a document icon or other representation for non-image files -->
                                                                                    <span class="document-icon"> <img src="{{ asset('assets/backend/img/document-default.png') }}" class="custom-file-preview" /></span>
                                                                                @endif
                                                                            @endif
                                                                        </div>


                                                                        <label class="custom-file-label" for="create-form-image3">Choose file</label>


                                                                    </div>
                                                                    @if ($deliverypartner->driving_licence != '')
                                                                    <div><a href="javascript:void(0);" class="custom-file-preview view-file-button mt-3" data-url="{{ asset('uploads/' . $deliverypartner->driving_licence) }}" data-type="file">Show</a> </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>


                                                        <div class="col-md-2 col-sm-12">

                                                            <div class="form-group">
                                                                <label>{{ __('RC') }} </label>
                                                                <div class="parent-remove">
                                                                    <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                            <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                                        </svg>
                                                                    </a>
                                                                    <div class="custom-file">
                                                                        <input type="file" id="create-form-image4" class="custom-file-input" name="rc" data-name="rc" hidden accept=".jpg, .jpeg, .png, .pdf, .doc, .docx, application/msword">
                                                                        <input type="hidden" name="remove_rc" class="remove-image">


                                                                        <div class="preview">
                                                                            @if ($deliverypartner->rc == '')
                                                                                <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                            @else
                                                                                @php
                                                                                    $fileExtension = pathinfo($deliverypartner->rc, PATHINFO_EXTENSION);
                                                                                @endphp
                                                                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                                                                    <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $deliverypartner->aadhar_card) }}" class="custom-file-preview" />
                                                                                @else
                                                                                    <!-- Display a document icon or other representation for non-image files -->
                                                                                    <span class="document-icon"> <img src="{{ asset('assets/backend/img/document-default.png') }}" class="custom-file-preview" /></span>
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                        <label class="custom-file-label" for="create-form-image4">Choose file</label>

                                                                    </div>
                                                                    @if ($deliverypartner->rc != '')
                                                                    <div><a href="javascript:void(0);" class="custom-file-preview view-file-button mt-3" data-url="{{ asset('uploads/' . $deliverypartner->rc) }}" data-type="file">Show</a> </div>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 gf-order-delivery-dtls-out">
                                                <div class="gf-order-delivery-dtls">
                                                    <h3>Earning Criteria</h3>


                                                    <div class="form-group mt-3">
                                                        <label>{{ __('Charge Per Kilometer') }} </label>
                                                        <div>
                                                            <input type="text" name="charge_per_km" class="form-control input-mask" value="{{ $deliverypartner->charge_per_km }}" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Success Delivery Amount') }} </label>
                                                        <div>
                                                            <input type="text" name="success_delivery_amount" class="form-control input-mask" value="{{ $deliverypartner->success_delivery_amount }}" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">

                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Weekend Incentive') }} </label>
                                                        <div>
                                                            <input type="text" name="weekend_incentive" class="form-control input-mask" value="{{ $deliverypartner->weekend_incentive }}" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">


                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>{{ __('Daily Incentive') }} </label>
                                                        <div>
                                                            <input type="text" name="daily_incentive" class="form-control input-mask" value="{{ $deliverypartner->daily_incentive }}" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>{{ __('Holiday Incentive') }} </label>
                                                        <div>
                                                            <input type="text" name="holiday_incentive" class="form-control input-mask" value="{{ $deliverypartner->holiday_incentive }}" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">

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

                                                                    <input type="number" id="radius" name="delivery_radius" placeholder="Enter radius" class="form-control" value="{{ $deliverypartner->delivery_radius }}">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="radius">Delivery Area:</label>

                                                                    <input type="text" id="search-input" name="delivery_area" class="form-control" placeholder="Enter location" value="{{ $deliverypartner->delivery_area }}">
                                                                </div>
                                                            </div>


                                                        </div>
                                                        <div class="col-md-2">
                                                            <button id="search-button" class="btn btn-primary ms-2 mt-3">Search</button>
                                                        </div>
                                                        <div class="col-md-8 mt-3">
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
                                                    Update
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
    {{-- <script src="{{ asset('assets/backend/js/deliveryMap.js') }}"></script> --}}

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

        // Add a click event listener to capture latitude and longitude and add a marker
        map.on('click', function(e) {
            e.originalEvent.preventDefault();
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            // Perform reverse geocoding to get the area name and zoom in
            reverseGeocode(lat, lng);
        });

        // Add an event listener to draw a radius when the button is clicked
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

        // Load initial data and display marker and circle if available
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



        // JavaScript to open the file in a pop-up
        // Function to open the Bootstrap modal and set the file URL
    </script>
@endsection
