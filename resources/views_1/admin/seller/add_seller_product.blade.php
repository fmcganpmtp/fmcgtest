@extends('admin.master')
@section('title', 'Create Product')
@section('breadcrumb') Create Product @endsection
@section('content')




  <div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <div class="card-out mb-4 inner-form">
        <h2>Seller Product Creation</h2>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-12">
              <div class="card ">
    
              <div class="card-body">
              <div class="row">


                  
                  
                  
                  
                  <form method="POST" action="{{ route('save.seller_product') }}" aria-label="{{ __('Register') }}"  enctype="multipart/form-data">
                     
                        @csrf
            <div class="row">
              <input type="hidden" name="seller_id" value="{{$seller_id}}">          
               
             

            <div class=" col-lg-6 col-12">
                <div class="form-group">
                            <label for="name" >{{ __('Product name:') }} <span class="color_red">*</span></label>

                            <div >
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" >

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
					
					<div class=" col-lg-2 col-12"> <div class="form-group">
                  <label>Currency: <sup>*</sup></label>
                 <select name="currency_id" id="currency" class="form-control  {{ $errors->has('currency_id') ? ' is-invalid' : '' }}" aria-label="Default select example"  >
                    <option value="">Select</option>
                  @if(!empty($currencies))
                  @foreach ($currencies as $currency)
                  
                    <option  value="{{$currency->id}}">{{$currency->shortcode}}(<?=$currency->symbol?>)</option>
                    
                  @endforeach 
                  @endif
				   @if ($errors->has('currency_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('currency_id') }}</strong>
                                    </span>
                                @endif
                  </select>
                </div>
                    </div>
                    
                        <div class=" col-lg-4 col-12"><div class="form-group">
                            <label for="product_price" >{{ __('Product Price') }}<sup id="not_man">*</sup> </label>

                            <div >
                                <input id="product_price"  type="text"  class="form-control{{ $errors->has('product_price') ? ' is-invalid' : '' }}" name="product_price" value="{{ old('product_price') }}" >

                                @if ($errors->has('product_price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                        
                        <div class=" col-lg-4 col-12 price_request_outer">
                              <div class="form-group">
                                 <label for="stock_count" >{{ __('Price on request:') }} </label>
                                 <div class="form-field-style">
                                    <input type="checkbox" name="price_on_request" {{ old('price_on_request') ? 'checked' : '' }} class="price_request" value="Price on request"> {{ __('Price on request') }}
                                 </div>
                              </div>
                           </div>
                           <div class=" col-lg-4 col-12 negotiable_outer">
                              <div class="form-group">
                                 <label for="stock_count" >{{ __('Negotiable:') }} </label>
                                 <div class="form-field-style">
                                    <input type="checkbox" name="price_negotiable" {{ old('price_negotiable') ? 'checked' : '' }} class="negotiable" value="Negotiable"> {{ __('Negotiable') }}
                                 </div>
                              </div>
                           </div>
                          <div class=" col-lg-6  col-12">
                <div class="form-group">
                  <label> Category:</label>
                  <?php $selectedCategories = []; ?>
                  <select type="text"   id="category" name="category_id" class="form-control" >
                                        <option value="">None</option>
                                        @if($categories)
                                            @foreach($categories as $item)
                                            <?php $dash=''; ?>
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                


                                            @endforeach
                                        @endif
                                    </select>
                </div>
              </div>
			  <div class=" col-lg-6  col-12  sub_cat" style="display:none;">
                <div class="form-group">
                  <label>Sub Category:</label>
                  <?php $selectedCategories = []; ?>
                  <select name="subcategory_id" id="subcategory" class="form-control input-sm">
                   <option value=""></option>
                  </select>
                </div>
              </div>
			  <div class=" col-lg-6  col-12 subsub_cat" style="display:none;">
                <div class="form-group">
                  <label>Sub Category:</label>
                  <?php $selectedCategories = []; ?>
                  <select name="subsubcategory_id" id="subsubcategory" class="form-control input-sm">
                     <option value=""></option>
                   </select>
                </div>
              </div>
                        
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="SKU" >{{ __('SKU:') }} </label>
 
                            <div >
                                <input id="SKU" type="text" class="form-control{{ $errors->has('SKU') ? ' is-invalid' : '' }}" name="SKU" value="{{ old('SKU') }}" >

                                @if ($errors->has('SKU'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('SKU') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="stock_count" >{{ __('Product Brand:') }} </label>
 
                            <div >
                            <select type="text" name="brands" class="form-control">
                                        <option value="">None</option>
                                        @if($Productbrand)
                                            @foreach($Productbrand as $item)
                                               <option value="{{$item->id}}" >{{$item->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                             @if ($errors->has('brands'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('brands') }}</strong>
                                 </span>
                             @endif
                            </div>
                        </div></div>
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="feature" >{{ __('Features:') }} </label>
 
                            <div >
                                <input id="feature" type="text" class="form-control{{ $errors->has('feature') ? ' is-invalid' : '' }}" name="feature" value="{{ old('feature') }}" >

                                @if ($errors->has('feature'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('feature') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						<div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="brix" >{{ __('Brix(%):') }} </label>
 
                            <div >
                                <input id="brix" type="text"     class="form-control{{ $errors->has('brix') ? ' is-invalid' : '' }}" name="brix" value="{{ old('brix') }}" >

                                @if ($errors->has('brix'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('brix') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						<div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="packaging" >{{ __('Packaging:') }} </label>
 
                            <div >
                                <input id="packaging" type="text" class="form-control{{ $errors->has('packaging') ? ' is-invalid' : '' }}" name="packaging" value="{{ old('packaging') }}" >

                                @if ($errors->has('packaging'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('packaging') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						<div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="place_of_origin" >{{ __('Place of origin:') }} </label>
 
                            <div >
                                <input id="place_of_origin" type="text" class="form-control{{ $errors->has('place_of_origin') ? ' is-invalid' : '' }}" name="place_of_origin" value="{{ old('place_of_origin') }}" >

                                @if ($errors->has('place_of_origin'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('place_of_origin') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						<div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="model_number" >{{ __('Model Number:') }}</label>
 
                            <div >
                                <input id="model_number" type="text" class="form-control{{ $errors->has('model_number') ? ' is-invalid' : '' }}" name="model_number" value="{{ old('model_number') }}" >

                                @if ($errors->has('model_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('model_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						<div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="primary_ingredients" >{{ __('Primary ingredients:') }} </label>
 
                            <div >
                                <input id="primary_ingredients" type="text" class="form-control{{ $errors->has('primary_ingredients') ? ' is-invalid' : '' }}" name="primary_ingredients" value="{{ old('primary_ingredients') }}">

                                @if ($errors->has('primary_ingredients'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('primary_ingredients') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						<div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="additives" >{{ __('Additives:') }}</label>
 
                            <div >
                                <input id="additives" type="text" class="form-control{{ $errors->has('additives') ? ' is-invalid' : '' }}" name="additives" value="{{ old('additives') }}" >

                                @if ($errors->has('additives'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('additives') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						<div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="flavor" >{{ __('Flavor:') }}</label>
 
                            <div >
                                <input id="flavor" type="text" class="form-control{{ $errors->has('flavor') ? ' is-invalid' : '' }}" name="flavor" value="{{ old('flavor') }}" >

                                @if ($errors->has('flavor'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('flavor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						<div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="certification" >{{ __('Certification:') }}</label>
 
                            <div >
                                <input id="certification" type="text" class="form-control{{ $errors->has('certification') ? ' is-invalid' : '' }}" name="certification" value="{{ old('certification') }}" >

                                @if ($errors->has('certification'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('certification') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						 <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="volume" >{{ __('Volume:') }}</label>
 
                            <div >
                                <input id="volume" type="text" class="form-control{{ $errors->has('volume') ? ' is-invalid' : '' }}" name="volume" value="{{ old('volume') }}" >

                                @if ($errors->has('volume'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('volume') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						 <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="BBD" >{{ __('BBD:') }} </label>
 
                            <div >
                                <input id="BBD" type="text" class="form-control{{ $errors->has('BBD') ? ' is-invalid' : '' }}" name="BBD" value="{{ old('BBD') }}" >

                                @if ($errors->has('BBD'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('BBD') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						
						<div class=" col-lg-6 col-12 stk_cnt"><div class="form-group">
                            <label for="stock_count" >{{ __('Stock Count:') }} </label>
 
                            <div >
                                <input id="stock_count" type="text" class="form-control{{ $errors->has('stock_count') ? ' is-invalid' : '' }}" name="stock_count" value="{{ old('stock_count') }}"  >

                                @if ($errors->has('stock_count'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('stock_count') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						
						<div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="stock_count" >{{ __('Stock:') }} </label>
 
                            <div >
                          
                             <input type="checkbox" name="unlimited_stock" {{ old('unlimited_stock') ? 'checked' : '' }}   class="unlimited"  value="Unlimited"> {{ __('Unlimited stock') }}
                            </div>
                        </div></div>
						
                        
                        
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_color" >{{ __('Product Color:') }}</label>
 
                            <div >
                                <input id="product_color" type="text" class="form-control{{ $errors->has('product_color') ? ' is-invalid' : '' }}" name="product_color" value="{{ old('product_color') }}"  autofocus>

                                @if ($errors->has('product_color'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_color') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                        
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_weight" >{{ __('Weight (In Kg):') }} </label>
 
                            <div >
                                <input id="product_weight" type="text" class="form-control{{ $errors->has('product_weight') ? ' is-invalid' : '' }}" name="product_weight" value="{{ old('product_weight') }}"  autofocus>

                                @if ($errors->has('product_weight'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_weight') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                        
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_size" >{{ __('Size:') }} </label>
 
                            <div >
                                <input id="product_size" type="text" class="form-control{{ $errors->has('product_size') ? ' is-invalid' : '' }}" name="product_size" value="{{ old('product_size') }}"  autofocus>

                                @if ($errors->has('product_size'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_size') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_dimension" >{{ __('Dimensions:') }} </label>
 
                            <div >
                                <input id="product_dimension" type="text" class="form-control{{ $errors->has('product_dimension') ? ' is-invalid' : '' }}" name="product_dimension" value="{{ old('product_dimension') }}"  autofocus>

                                @if ($errors->has('product_dimension'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_dimension') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                        
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="variants" >{{ __('Varients:') }} </label>
 
                            <div >
                                 <select type="text" multiple  name="variants[]" id='variants' class="form-control{{ $errors->has('variants') ? ' is-invalid' : '' }}">
          </select>
                               
                                @if ($errors->has('variants'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('variants') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>

                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_expiry" >{{ __('Product Expiry:') }} </label>
 
                            <div >
                                <input id="product_expiry" type="Date" class="form-control{{ $errors->has('product_expiry') ? ' is-invalid' : '' }}" name="product_expiry" value="{{ old('product_expiry') }}"  autofocus>

                                @if ($errors->has('product_expiry'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_expiry') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                        
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_image" >{{ __('Thumbnail image:') }} </label>
 
                            <div >
                            <input type="file" id="input-file-now-custom-3" class="form-control m-2"  name="product_image" accept="image/png, image/gif, image/jpeg" >
                               
                                @if ($errors->has('product_image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_image') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                        
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_gallery" >{{ __('Gallery Images(multiple upload):') }} </label>
 
                            <div >
                            <input type="file" id="input-file-now-custom-3" class="form-control m-2" name="product_gallery[]"  multiple accept="image/png, image/gif, image/jpeg" >
                                
                                @if ($errors->has('product_gallery'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_gallery') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                        
                        <div class=" col-lg-6 col-12">
                <div class="form-group">
                            <label for="company_name" >{{ __('Company Name:') }}</label>

                            <div >
                                <input id="company_name" type="text" class="form-control" name="company_name" value="{{ old('company_name') }}"> 
                            </div>
                        </div>
                    </div>
                    
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="location" >{{ __('Location') }} </label>

                            <div >
                                <input id="location"  type="text"  class="form-control" name="location" value="{{ old('location') }}">                            
                            </div>
                        </div>
                    </div>
                    <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="location" >{{ __('Etiket / label language') }} </label>

                            <div >
                                <input id="label_language"  type="text"  class="form-control" name="label_language" value="{{ old('label_language') }}">                            
                            </div>
                        </div>
                    </div>
                         <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="Minimal Order" >{{ __('Minimal Order') }} </label>

                            <div >
                                <input id="minimal_order"  type="text"  class="form-control" name="minimal_order" value="{{ old('minimal_order') }}">                            
                            </div>
                        </div>
                    </div>
                     <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_condition" >{{ __('Product Condition') }} </label>

                            <div >

                               
                                <select class="form-control" name="product_condition" {{ old('product_condition') }}>
                                    <option value="New">New</option>
                                    <option value="Used">Used</option>
                                    <option value="Refurbished">Refurbished</option>
                                    <option value="Damaged">Damaged</option>
                                </select>                        
                            </div>
                        </div>
                    </div>
                        
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="available_countries" >{{ __('Available Countries:') }} </label>
 
                            <div >
                                <select type="text" multiple placeholder="Available Countries" name="available_countries[]" id='available_countries' class="form-control{{ $errors->has('product_dimension') ? ' is-invalid' : '' }}">
          </select>
                                @if ($errors->has('available_countries'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('available_countries') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                        
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_description" >{{ __('Description') }}</label>

                            <div >
                               <textarea name="product_description" id="mytextarea" class="form-control{{ $errors->has('product_description') ? ' is-invalid' : '' }}" >{{ old('product_description') }}</textarea>
                                
                               @if ($errors->has('product_description'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>




                        <div class="form-group mb-0">
                            <div class="">
                                <button type="submit" class="bl-btn">
                                    {{ __('Save') }}
                                </button>
                                </div>
                        </div>







                  
            </div>
                  
                  </form>
                  
                  
                  
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>

</div>


  </div>

  <link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">
<script src="{{ asset('js/select2.min.js')}}"></script>
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.2.2/tinymce.min.js"></script>
<script type="text/javascript">



    tinymce.init({ selector:'textarea#mytextarea',
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
    link_list: [
      { title: 'My page 1', value: 'http://www.tinymce.com' },
      { title: 'My page 2', value: 'http://www.moxiecode.com' }
    ],
    image_list: [
      { title: 'My page 1', value: 'http://www.tinymce.com' },
      { title: 'My page 2', value: 'http://www.moxiecode.com' }
    ],
    image_class_list: [
      { title: 'None', value: '' },
      { title: 'Some class', value: 'class-name' }
    ],
    importcss_append: true,
    height: 400,
    file_picker_callback: function (callback, value, meta) {
      /* Provide file and text for the link dialog */
      if (meta.filetype === 'file') {
        callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
      }

      /* Provide image and alt text for the image dialog */
      if (meta.filetype === 'image') {
        callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
      }

      /* Provide alternative source and posted for the media dialog */
      if (meta.filetype === 'media') {
        callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
      }
    },
    templates: [
          { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
      { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
      { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
    ],
    template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
    template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
    height: 300,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_noneditable_class: "mceNonEditable",
    toolbar_mode: 'sliding',
    contextmenu: "link image imagetools table",
    valid_elements: "*[*]",
    images_upload_handler: function (blobInfo, success, failure) {
    var xhr, formData;
    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', "{{route('content.ajaxtiny')}}");
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

  </script>
<script type="text/javascript">
  
  
var route = "{{route('available.countries')}}";
  $('#available_countries').select2({
     placeholder: 'Select Available Countries',

    escapeMarkup: function(markup) { 
          return markup;
    },
    templateResult: function(data) {
       
      return data.html;
    },
    templateSelection: function(data) {
      

      if (data && !data.selected) 
      return data.text;
    },
    ajax: {
      url: route,
      dataType: 'json',
      delay: 250,
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
            return {
              html:"<span>"+item.name+"</span>",
              text: item.name,
              id: item.id
            }
          })
        };
      },
      cache: true,

    }
  });





  var route_varients = "{{route('autocomplete.product')}}";
  $('#variants').select2({
     placeholder: 'Select Varients',

    escapeMarkup: function(markup) { 
          return markup;
    },
    templateResult: function(data) {
       
      return data.html;
    },
    templateSelection: function(data) {
      

      if (data && !data.selected) 
      return data.text;
    },
    ajax: {
      url: route_varients,
      dataType: 'json',
      delay: 250,
      processResults: function(data) {
        return {
          results: $.map(data, function(item) {
            return {
              html:"<span>"+item.name+"</span>",
              text: item.name,
              id: item.id
            }
          })
        };
      },
      cache: true,

    }
  });
</script>


<script type="text/javascript">
$(document).ready(function () { 
      $(".unlimited").click(function() {
    if($(this).is(":checked")) {
        $(".stk_cnt").hide();
		
		$("#stock_count").val('');
    } else {
        $(".stk_cnt").show();
    }
});
 $(".price_request").click(function() {
        
      if($(this).prop("checked") == true){
                 $(".negotiable_outer").hide();
                 $(".negotiable").val('');
                 $("#not_man").hide();
                    } else {
                         $(".negotiable_outer").show();
                         $("#not_man").show();
                    }
                });
   
   
    $(".negotiable").click(function() {
        
      if($(this).prop("checked") == true){
                 $(".price_request_outer").hide();
                         $(".price_request").val('');

                    } else {
                         $(".price_request_outer").show();
                    }
                }); 
            $('#category').on('change',function(e){
            console.log(e);
            var cat_id = e.target.value; 
            var bse_url = "{{URL::to('/')}}";
            $.get(bse_url+'/ajax-subcat?cat_id='+ cat_id,function(data){
                var subcat =  $('#subcategory').empty();
				subcat.append('<option value ="">Select</option>');
				if(data.length>0){
                $.each(data,function(create,subcatObj){
					$('.sub_cat').show();
                    var option = $('<option/>', {id:create, value:subcatObj});
                    subcat.append('<option value ="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                });
				}
				else{
					$('.sub_cat').hide();
				}
				
            });
        });
		
		
		 <?php if(old('subcategory_id') ) { ?>

            var cat_id = <?=old('category_id')?>;
            var subcat_id = <?=old('subcategory_id')?>;
            var bse_url = "{{URL::to('/')}}";
            $.get(bse_url+'/ajax-subcat?cat_id='+ cat_id,function(data){
                var subcat =  $('#subcategory').empty();
				subcat.append('<option value ="">Select</option>');
				if(data.length>0){
                $.each(data,function(create,subcatObj){
					$('.sub_cat').show();
                    var option = $('<option/>', {id:create, value:subcatObj});
                    var selected='';
                    if(subcatObj.id==subcat_id){
                     var selected='selected';   
                    }
                    subcat.append('<option value ="'+subcatObj.id+'" '+selected+ '>'+subcatObj.name+'</option>');
                });
				}
				else{
					$('.sub_cat').hide();
				}
				
            });
    
		
<?php } ?>	


 <?php if(old('subsubcategory_id') ) { ?>

           
       
            var cat_id = <?=old('subcategory_id')?>; 
            var subsubcat_id = <?=old('subsubcategory_id')?>;
            var bse_url = "{{URL::to('/')}}";
            $.get(bse_url+'/ajax-subcat?cat_id='+ cat_id,function(data){
                var subcat =  $('#subsubcategory').empty();
				subcat.append('<option value ="">Select</option>');
				if(data.length>0){
                $.each(data,function(create,subcatObj){
					$('.subsub_cat').show();
                    var option = $('<option/>', {id:create, value:subcatObj});
                    var selected='';
                    if(subcatObj.id==subsubcat_id){
                     var selected='selected';   
                    }
                    subcat.append('<option value ="'+subcatObj.id+'" '+selected+ '>'+subcatObj.name+'</option>');
                });
				}
				else{
					$('.subsub_cat').hide();
				}
				
            });
    
		
<?php } ?>
		
		
		
		$('#subcategory').on('change',function(e){
            console.log(e);
            var cat_id = e.target.value; 
            var bse_url = "{{URL::to('/')}}";
            $.get(bse_url+'/ajax-subcat?cat_id='+ cat_id,function(data){
                var subcat =  $('#subsubcategory').empty();
				subcat.append('<option value ="">Select</option>');
				if(data.length>0){
                $.each(data,function(create,subcatObj){
					$('.subsub_cat').show();
                    var option = $('<option/>', {id:create, value:subcatObj});
                    subcat.append('<option value ="'+subcatObj.id+'">'+subcatObj.name+'</option>');
                });
				}
				else{
					$('.subsub_cat').hide();
				}
				
            });
        });
		
		
		
		
    });
</script>





@endsection