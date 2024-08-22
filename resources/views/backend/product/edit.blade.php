@extends('backend/layout/app', ['sidebar' => false])
@section('header')
    <div class="row align-items-center">
        <div class="col-md-4 col-sm-12">
            <div class="mb-1">
                <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
                    <li class="breadcrumb-item"><a href="javascript:;">Application</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('product') }}">{{ __('Product') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:">{{ __('New') }}</a></li>
                </ol>
            </div>
            <h2 class="page-title" act-on="click">{{ __('New Product') }}</h2>
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
                    <form act-on="submit" act-request="{{(isset($type)&&($type=='duplicate'))?route('product.duplicate.store'):route('product.update')}}">
                        <input type="hidden" name="_method" value="patch">

                        <div class="row">

                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Business Category') }} <span class="text-danger">*</span></label>
                                    <div>
                                        <select name="business_category_id" required class="form-select select2" act-on="change" act-request="{{ route('product.menu') }}">
                                            <option disabled selected value=""></option>
                                            @foreach ($businessCategories as $businessCategory)
                                                <option value="{{ $businessCategory->id }}" @if ($product->business_category_id == $businessCategory->id) selected @endif>{{ $businessCategory->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Menu Name') }} <span class="text-danger">*</span></label>
                                    <div>
                                        <select name="menu_id" id="menu" required act-on="change" act-request="{{ route('product.submenu') }}" class="form-select select2">
                                            <option disabled selected value=""></option>
                                            @foreach ($menus as $menu)
                                                <option value="{{ $menu->id }}" @if ($product->menu_id == $menu->id) selected @endif>{{ $menu->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12">
                                <div class="form-group">
                                    <label>{{ __('Submenu Name') }} </label>
                                    <div>
                                        <select name="submenu_id" id="submenu" class="form-select select2">
                                            <option disabled selected value=""></option>
                                            @foreach ($submenus as $submenu)
                                                <option value="{{ $submenu->id }}" @if ($product->submenu_id == $submenu->id) selected @endif>{{ $submenu->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="repeater">

                            <div data-repeater-list="products">

                                @foreach ($products as $key => $product)
                                    <div class="repeater-item" data-repeater-item>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="repeater-title-box d-flex align-items-center justify-content-between">
                                                    <div class="repeater-title">
                                                        {{ __('Product') }}
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
                                                    <label>{{ __('Name') }} <span class="text-danger">*</span></label>
                                                    <div>
                                                        <input type="text" name="name" value="{{ $product->name }}" required class="form-control">
                                                        <input type="hidden" name="id" value="{{ $product->id }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Short Description') }} </label>
                                                    <div>
                                                        <input type="text" name="short_description" value="{{ $product->short_description }}" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Brand') }}</label>
                                                    <div>
                                                        <select name="brand_id" class="form-select">
                                                            <option selected value="">&nbsp;</option>
                                                            @foreach ($brands as $brand)
                                                                <option @if ($product->brand_id == $brand->id) selected @endif value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Weight / Count/ Portion') }} <span class="text-danger">*</span></label>
                                                    <div>
                                                        <input type="text" name="variant_option" value="{{ $product->variant_option }}" required placeholder="Eg: 100 gm, 2kg, 1 x 70 gm, Half, Full, 3 count, etc..." class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Price') }} </label>
                                                    <div>
                                                        <input type="text" name="price" value="{{ $product->price }}" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Selling Price') }} </label>
                                                    <div>
                                                        <input type="text" name="selling_price" value="{{ $product->selling_price }}" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Weight ( Including Packaging in kg )') }} <span class="text-danger">*</span></label>
                                                    <div>
                                                        <input type="text" name="weight" value="{{ $product->weight }}" required class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Max Qty') }} </label>
                                                    <div>
                                                        <input type="text" name="max_qty" value="{{ $product->max_qty }}" class="form-control input-mask" data-inputmask="'alias': 'decimal', 'digits': 2, 'allowMinus': false, 'rightAlign': false">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Type') }}</label>
                                                    <div>
                                                        <select name="type" class="form-select">
                                                            <option selected value="">&#12288</option>
                                                            <option @if ($product->type == 'veg') selected @endif value="veg">Veg</option>
                                                            <option @if ($product->type == 'non-veg') selected @endif value="non-veg">Non Veg</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Disclaimer') }} </label>
                                                    <div>
                                                        <textarea class="form-control" name="description" rows="4">{{ $product->description }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Keywords') }} </label>
                                                    <div>
                                                        <textarea class="form-control" name="keywords" rows="4">{{ $product->keywords }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-1 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Product Image') }} </label>
                                                    <div class="parent-remove">
                                                        <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                            </svg>
                                                        </a>
                                                        <div class="custom-file">
                                                            <input type="file" id="create-form-image" class="custom-file-input" name="image" data-name="image" hidden accept="image/*">
                                                            <input type="hidden" name="remove_image" class="remove-image">

                                                            <div class="preview">
                                                                @if ($product->image == '')
                                                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                @else
                                                                    <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $product->image) }}" class="custom-file-preview" />
                                                                @endif
                                                            </div>
                                                            <label class="custom-file-label" for="create-form-image">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-lg-1 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Gallery Image 1') }} </label>
                                                    <div class="parent-remove">
                                                        <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                            </svg>
                                                        </a>
                                                        <div class="custom-file">

                                                            <input type="file" id="create-form-image-2" class="custom-file-input" name="gallery_image_1" data-name="gallery_image_1" hidden accept="image/*">
                                                            <input type="hidden" name="remove_gallery_1" class="remove-image">
                                                            <div class="preview">
                                                                @if ($product->gallery_image_1 == '')
                                                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                @else
                                                                    <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $product->gallery_image_1) }}" class="custom-file-preview" />
                                                                @endif
                                                            </div>
                                                            <label class="custom-file-label" for="create-form-image-2">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <input type="hidden" default-image="{{ asset('assets/backend/img/upload-image.png') }}" id="default-img">
                                            <div class="col-lg-1 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Gallery Image 2') }} </label>
                                                    <div class="parent-remove">
                                                        <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                            </svg>
                                                        </a>
                                                        <div class="custom-file">
                                                            <input type="file" id="create-form-image-3" class="custom-file-input" name="gallery_image_2" data-name="gallery_image_2" hidden accept="image/*">
                                                            <input type="hidden" name="remove_gallery_2" class="remove-image">

                                                            <div class="preview">
                                                                @if ($product->gallery_image_2 == '')
                                                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                @else
                                                                    <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $product->gallery_image_2) }}" class="custom-file-preview" />
                                                                @endif
                                                            </div>
                                                            <label class="custom-file-label" for="create-form-image-3">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-lg-1 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Gallery Image 3') }} </label>
                                                    <div class="parent-remove">
                                                        <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                            </svg>
                                                        </a>
                                                        <div class="custom-file">
                                                            <input type="file" id="create-form-image-4" class="custom-file-input" name="gallery_image_3" data-name="gallery_image_3" hidden accept="image/*">
                                                            <input type="hidden" name="remove_gallery_3" class="remove-image">

                                                            <div class="preview">
                                                                @if ($product->gallery_image_3 == '')
                                                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                @else
                                                                    <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $product->gallery_image_3) }}" class="custom-file-preview" />
                                                                @endif
                                                            </div>
                                                            <label class="custom-file-label" for="create-form-image-4">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-lg-1 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Gallery Image 4') }} </label>
                                                    <div class="parent-remove">
                                                        <a href="javascript:void(0)" class="custom-file-input-remove" title="view">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="20" height="20">
                                                                <path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm121.6 313.1c4.7 4.7 4.7 12.3 0 17L338 377.6c-4.7 4.7-12.3 4.7-17 0L256 312l-65.1 65.6c-4.7 4.7-12.3 4.7-17 0L134.4 338c-4.7-4.7-4.7-12.3 0-17l65.6-65-65.6-65.1c-4.7-4.7-4.7-12.3 0-17l39.6-39.6c4.7-4.7 12.3-4.7 17 0l65 65.7 65.1-65.6c4.7-4.7 12.3-4.7 17 0l39.6 39.6c4.7 4.7 4.7 12.3 0 17L312 256l65.6 65.1z" />
                                                            </svg>
                                                        </a>
                                                        <div class="custom-file">
                                                            <input type="file" id="create-form-image-5" class="custom-file-input" name="gallery_image_4" data-name="gallery_image_4" hidden accept="image/*">
                                                            <input type="hidden" name="remove_gallery_4" class="remove-image">

                                                            <div class="preview">
                                                                @if ($product->gallery_image_4 == '')
                                                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview" />
                                                                @else
                                                                    <img default-src="{{ asset('assets/backend/img/upload-image.png') }}" src="{{ asset('uploads/' . $product->gallery_image_4) }}" class="custom-file-preview" />
                                                                @endif
                                                            </div>
                                                            <label class="custom-file-label" for="create-form-image-5">Choose file</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>{{ __('Description') }} </label>
                                                    <div>
                                                        <textarea name="product_description" id="product_description_{{ $key }}" class="form-control product-description-class">{!! $product->product_description !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                @endforeach

                            </div>


                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <div class="form-group mb-0 mb-3">
                                        <div class="d-flex justify-content-left">
                                            <button type="button" data-repeater-create class="btn btn-warning waves-effect waves-light mr-2 px-3">
                                                {{ __('Add Variation') }}
                                            </button>
                                        </div>
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
                                       {{(isset($type)&&($type=='duplicate'))?'Duplicate':'Update'}}
                                    </button>
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
        @foreach ($products as $key => $product)
            initTinyMCE('product_description_' + {{ $key }})

        @endforeach
        function initTinyMCE(textareaId) {
            tinymce.init({
                selector: 'textarea#' + textareaId,
                plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                imagetools_cors_hosts: ['picsum.photos'],
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
                toolbar_sticky: true,
                autosave_ask_before_unload: true,
                autosave_interval: "30s",
                autosave_prefix: "{path}{query}-{id}-",
                autosave_restore_when_empty: false,
                autosave_retention: "2m",
                image_advtab: true,
                content_css: '//www.tiny.cloud/css/codepen.min.css',
                link_list: [{
                        title: 'My page 1',
                        value: 'http://www.tinymce.com'
                    },
                    {
                        title: 'My page 2',
                        value: 'http://www.moxiecode.com'
                    }
                ],
                image_list: [{
                        title: 'My page 1',
                        value: 'http://www.tinymce.com'
                    },
                    {
                        title: 'My page 2',
                        value: 'http://www.moxiecode.com'
                    }
                ],
                image_class_list: [{
                        title: 'None',
                        value: ''
                    },
                    {
                        title: 'Some class',
                        value: 'class-name'
                    }
                ],
                importcss_append: true,
                height: 400,
                file_picker_callback: function(callback, value, meta) {
                    /* Provide file and text for the link dialog */
                    if (meta.filetype === 'file') {
                        callback('https://www.google.com/logos/google.jpg', {
                            text: 'My text'
                        });
                    }

                    /* Provide image and alt text for the image dialog */
                    if (meta.filetype === 'image') {
                        callback('https://www.google.com/logos/google.jpg', {
                            alt: 'My alt text'
                        });
                    }

                    /* Provide alternative source and posted for the media dialog */
                    if (meta.filetype === 'media') {
                        callback('movie.mp4', {
                            source2: 'alt.ogg',
                            poster: 'https://www.google.com/logos/google.jpg'
                        });
                    }
                },
                templates: [{
                        title: 'New Table',
                        description: 'creates a new table',
                        content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
                    },
                    {
                        title: 'Starting my story',
                        description: 'A cure for writers block',
                        content: 'Once upon a time...'
                    },
                    {
                        title: 'New list with dates',
                        description: 'New List with dates',
                        content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
                    }
                ],
                template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
                template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
                height: 600,
                image_caption: true,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_noneditable_class: "mceNonEditable",
                toolbar_mode: 'sliding',
                contextmenu: "link image imagetools table",
                valid_elements: "*[*]",
                images_upload_handler: function(blobInfo, success, failure) {
                    var xhr, formData;
                    xhr = new XMLHttpRequest();
                    xhr.withCredentials = false;
                    xhr.open('POST', "{{ route('content.ajaxtiny') }}");
                    xhr.onload = function() {
                        var json;

                        if (xhr.status != 200) {
                            failure('HTTP Error: ' + xhr.status);
                            return;
                        }
                        json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                        success(json.location);
                    };
                    formData = new FormData();
                    formData.append('_token', "{{ csrf_token() }}");
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    xhr.send(formData);
                }
            });
        }
    </script>
@endsection
