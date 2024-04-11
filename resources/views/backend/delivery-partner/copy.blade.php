@extends('backend/layout/app')
@section('header')
<div class="row align-items-center">
   <div class="col-md-4 col-sm-12">
      <div class="mb-1">
         <ol class="breadcrumb breadcrumb-alternate" aria-label="breadcrumbs">
            <li class="breadcrumb-item"><a href="javascript:;">{{ __('Application') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product') }}">{{ __('Product Template') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="javascript:;">{{ __('Edit') }}</a></li>
         </ol>
      </div>
      <h2 class="page-title" act-on="click">{{ __('Edit Product Template') }}</h2>
   </div>
   <div class="col-auto ms-auto d-print-none">
      <div class="d-flex">
         @if(hasPermission('product'))
         <a href="{{ route('product') }}" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
               <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
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
            <form act-on="submit" act-request="{{ route('product.store') }}" act-image-compress="image, gallery_image_1, gallery_image_2, gallery_image_3">
               <div class="row">
                  <div class="card">
                     <div class="card-body p-0 pt-2">
                        <div class="tab-content">
                           <div class="tab-pane active show" id="tabs-create-form">
 
                              <div class="row">
                                 <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                       <label>{{ __('Name') }}  <span class="text-danger">*</span></label>
                                       <div>
                                          <input type="text" name="name" required   class="form-control">
                                       </div>
                                    </div>
                                 </div>


                                 <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                       <label>{{ __('Menu') }} <span class="text-danger">*</span></label>
                                       <div>
                                          <select name="menu_id" class="form-select select2" required act-on="change" act-request="{{ route('product.submenu') }}">
                                              <option value="">&nbsp;</option>
                                                @foreach($menu as $menuItem)
                                                    
                                                    @if($menuItem->id == $product->menu_id)
                                                    <option value="{{$menuItem->id}}" selected>{{$menuItem->name}}</option>
                                                    @else
                                                    <option value="{{$menuItem->id}}">{{$menuItem->name}}</option>
                                                    @endif
                                                
                                                @endforeach
                                          </select>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                       <label>{{ __('Submenu') }}</label>
                                       <div>
                                          <select id="submenu" name="submenu_id" class="form-select select2">
                                              <option value="">&nbsp;</option>
                                                @foreach($submenu as $submenuItem)
                                                    
                                                    @if($submenuItem->id == $product->submenu_id)
                                                    <option value="{{$submenuItem->id}}" selected>{{$submenuItem->name}}</option>
                                                    @else
                                                    <option value="{{$submenuItem->id}}">{{$submenuItem->name}}</option>
                                                    @endif
                                                
                                                @endforeach
                                          </select>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                       <label>{{ __('Type') }}</label>
                                       <div>
                                          <select name="type" class="form-select select2">
                                             <option value="" @if($product->type == '') {{ 'selected' }} @endif>&#12288</option>   
                                             <option value="veg" @if($product->type == 'veg') {{ 'selected' }} @endif>Veg</option>
                                             <option value="non-veg" @if($product->type == 'non-veg') {{ 'selected' }} @endif>Non Veg</option>
                                          </select> 
                                       </div>
                                    </div>
                                 </div> 

      
                                 <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                       <label>{{ __('Unit') }} <span class="text-danger">*</span></label>
                                       <div>
                                          <select name="unit_id" required class="form-select select2">
                                              <option disabled selected value=""></option>
                                                @foreach($units as $unit)
                                                    
                                                    @if($unit->id == $product->unit_id)
                                                    <option value="{{$unit->id}}" selected>{{$unit->name}}</option>
                                                    @else
                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                    @endif
                                                
                                                @endforeach
                                          </select>
                                       </div>
                                    </div>
                                 </div>

 
                                 <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                       <label>{{ __('Brand') }}</label>
                                       <div>
                                          <select name="brand_id" class="form-select select2">
                                              <option value="">&nbsp;</option>
                                                @foreach($brands as $brand)
                                                    
                                                    @if($brand->id == $product->brand_id)
                                                    <option value="{{$brand->id}}" selected>{{$brand->name}}</option>
                                                    @else
                                                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                                                    @endif
                                                
                                                @endforeach
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 
                                 <div class="col-sm-12">
                                    <div class="row">
                                       <div class="col-lg-8 col-sm-12 order-2 order-sm-1">
                                          <div class="row">
 
                                             <div class="col-sm-12">
                                                <div class="form-group">
                                                   <label>{{ __('Short Description') }} </label>
                                                   <div>
                                                      <input type="text" name="short_description" value="{{ $product->short_description }}"  class="form-control">
                                                   </div>
                                                </div>
                                             </div>

                                             <div class="col-sm-12">
                                                <div class="form-group">
                                                   <label>{{ __('Description') }} </label>
                                                   <div>
                                                      <textarea class="form-control"  name="description" rows="2">{{ $product->description }}</textarea>
                                                   </div>
                                                </div>
                                             </div>
                                             
                                             <div class="col-sm-12">
                                                <div class="form-group">
                                                   <label>{{ __('Search Keywords') }} </label>
                                                   <div>
                                                      <textarea class="form-control"  name="keywords" placeholder="Enter Comma Separated Keywords Eg: Chicken, Kozhi, Murgi" rows="2">{{ $product->keywords }}</textarea>
                                                   </div>
                                                </div>
                                             </div>


                                             <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                   <label>{{ __('Variable Product') }} <span class="text-danger">*</span></label>
                                                   <div>
                                                      <select id="variable-product" name="variable_product" class="form-select select2">
                                                         <option @if($product->combination_key == '') selected @endif value="no">No</option>
                                                         <option @if($product->combination_key != '') selected @endif value="yes">Yes</option>
                                                      </select>
                                                   </div>  
                                                </div>
                                             </div>

                                             <div class="col-lg-6 col-sm-12">
                                                <div class="form-group">
                                                   <label>{{ __('Status') }}  <span class="text-danger">*</span></label>
                                                   <div>
                                                      <select name="status" required class="form-select select2">
                                                         <option value="draft" @if($product->status == 'draft') {{ 'selected' }} @endif>Draft</option>
                                                         <option value="published" @if($product->status == 'published') {{ 'selected' }} @endif>Published</option>
                                                         <option value="expired" @if($product->status == 'expired') {{ 'selected' }} @endif>Expired</option>
                                                      </select>  
                                                   </div>
                                                </div>
                                             </div>



                                          </div>
                                       </div>

                                      <div class="col-lg-4 col-sm-12 order-1 order-sm-2">
 
                                            <div class="row">
        
        

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                    <label>{{ __('Default Image') }} 
                                                        <i data-bs-toggle="tooltip" data-placement="top" title="Size : 800px X 600px">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12.01" y2="8" /><polyline points="11 12 12 12 12 16 13 16" /></svg>
                                                        </i>
                                                    </label>
                                                        <div>
                                                            <div class="custom-file">
                                                                <input type="file" id="edit-form-image" class="custom-file-input" name="image" hidden accept="image/*">
                                                                <div class="preview">
                                                                    @if( $product->image == '')
                                                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview"/>
                                                                    @else
                                                                    <img src="{{ asset('uploads/' . $product->image) }}" class="custom-file-preview"/>
                                                                    @endif
                                                                </div>
                                                                <label class="custom-file-label" for="edit-form-image">Choose file</label>
                                                            </div>                                    
                                                        </div>
                                                    </div>
                                                </div>  


                                            </div>

                                            <div class="row mt-4">

                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>{{ __('Gallery Image') }}
                                                        <i data-bs-toggle="tooltip" data-placement="top" title="Size : 800px X 600px">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12.01" y2="8" /><polyline points="11 12 12 12 12 16 13 16" /></svg>
                                                        </i>     
                                                        </label>
                                                        <div>
                                                            <div class="custom-file">
                                                                <input type="file" id="edit-form-gallery-image-1" class="custom-file-input" name="gallery_image_1" hidden accept="image/*">
                                                                <div class="preview">
                                                                    @if( $product->gallery_image_1 == '')
                                                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview"/>
                                                                    @else
                                                                    <img src="{{ asset('uploads/' . $product->gallery_image_1) }}" class="custom-file-preview"/>
                                                                    @endif
                                                                </div>
                                                                <label class="custom-file-label" for="edit-form-gallery-image-1">Choose file</label>
                                                            </div>                                    
                                                        </div>
                                                    </div>
                                                </div>  


                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>{{ __('Gallery Image') }} 
                                                        <i data-bs-toggle="tooltip" data-placement="top" title="Size : 800px X 600px">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12.01" y2="8" /><polyline points="11 12 12 12 12 16 13 16" /></svg>
                                                        </i>
                                                        </label>
                                                        <div>
                                                            <div class="custom-file">
                                                                <input type="file" id="edit-form-gallery-image-2" class="custom-file-input" name="gallery_image_2" hidden accept="image/*">
                                                                <div class="preview">
                                                                    @if( $product->gallery_image_2 == '')
                                                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview"/>
                                                                    @else
                                                                    <img src="{{ asset('uploads/' . $product->gallery_image_2) }}" class="custom-file-preview"/>
                                                                    @endif
                                                                </div>
                                                                <label class="custom-file-label" for="edit-form-gallery-image-2">Choose file</label>
                                                            </div>                                    
                                                        </div>
                                                    </div>
                                                </div>  


                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>{{ __('Gallery Image') }} 
                                                        <i data-bs-toggle="tooltip" data-placement="top" title="Size : 800px X 600px">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="12" y1="8" x2="12.01" y2="8" /><polyline points="11 12 12 12 12 16 13 16" /></svg>
                                                        </i>
                                                        </label>
                                                        <div>
                                                            <div class="custom-file">
                                                                <input type="file" id="edit-form-gallery-image-3" class="custom-file-input" name="gallery_image_3" hidden accept="image/*">
                                                                <div class="preview">
                                                                    @if( $product->gallery_image_3 == '')
                                                                    <img src="{{ asset('assets/backend/img/upload-image.png') }}" class="custom-file-preview"/>
                                                                    @else
                                                                    <img src="{{ asset('uploads/' . $product->gallery_image_3) }}" class="custom-file-preview"/>
                                                                    @endif
                                                                </div>
                                                                <label class="custom-file-label" for="edit-form-gallery-image-3">Choose file</label>
                                                            </div>                                    
                                                        </div>
                                                    </div>
                                                </div>  
        
                                            </div>
    
                                        </div>
                                    </div>
                                 </div>
 
                              </div>
 
                              <div id="variable-product-inputs" class="row @if($product->combination_key == '') d-none @endif">
 
                                 <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                       <label>{{ __('Combination') }} <span class="text-danger">*</span></label>
                                       <div>
                                             <select id="combination" class="form-select select2">
                                                <option value="new">{{ __('New') }}</option>
                                                <option selected value="existing">{{ __('Existing') }}</option>
                                             </select>
                                       </div>
                                    </div>
                                 </div>
 
                                 <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                       <label>{{ __('Combination Attributes') }} <span class="text-danger">*</span></label>
                                       <div>
                                             <select name="attribute_id" act-on="change" act-request="{{ route('product.attribute') }}" class="form-select select2">
                                             <option value="">&nbsp;</option>
                                             @foreach($attributes as $attribute)
                                                   
                                                   @if($attribute->id == $product->attribute_id)
                                                   <option value="{{$attribute->id}}" selected>{{$attribute->name}}</option>
                                                   @else
                                                   <option value="{{$attribute->id}}">{{$attribute->name}}</option>
                                                   @endif
                                             
                                             @endforeach
                                             </select>
                                       </div>
                                    </div>
                                 </div>
 

                                 <div class="col-lg-4 col-sm-12">
                                    <div class="form-group">
                                       <label>{{ __('Combination Name') }} <span class="text-danger">*</span></label>
                                       <div id="combination-name-existing">
                                          <select name="combination_key"  class="form-select select2 w-100 combination_key">
                                             <option value="">&nbsp;</option>
                                             @foreach($groups as $combination)
                                             <option @if($product->combination_key == $combination->combination_key ) selected @endif value="{{ $combination->combination_key }}">{{ $combination->combination_key }}</option>
                                             @endforeach
                                          </select>
                                          
                                       </div>

                                       <div id="combination-name-new" class="d-none">
                                          <input type="text" disabled name="combination_key" class="form-control combination_key">
                                       </div>
                                    </div>
                                 </div>

                              </div>

                              <div id="variants">
                                    <div class="row" >
                                    @if($product->variants)
                                       @foreach($product->variants as $variant)
                                       <div class="col-lg-4 col-sm-12">
                                          <div class="form-group">
                                                <label>{{ $variant->name }} <span class="text-danger">*</span></label>
                                                <div>
                                                   <select name="variants[{{ $variant->id }}]" required class="form-select select2">
                                                      <option selected disabled value=""></option>
                                                      @if($variant->options)
                                                            @foreach($variant->options as $option)
                                                            <option @if($product->hasVariantOption($variant->id, $option->id)) {{ 'selected' }} @endif value="{{$option->id}}">{{$option->value}}</option>
                                                            @endforeach
                                                      @endif
                                                   </select>
                                                </div>
                                          </div>
                                       </div>
                                       @endforeach
                                    @endif
                                    </div>
                              </div>

                           </div>
 
                        </div>
                     </div>
                  </div>
               </div>
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
            </form>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
<script>
   $(function() {

      $('#combination').change(function(){
         if($(this).val() == 'existing'){
            $("#combination-name-existing").removeClass('d-none');
            $("#combination-name-existing .combination_key").prop('disabled', false);

            $("#combination-name-new").addClass('d-none');
            $("#combination-name-new .combination_key").prop('disabled', true);
         }else{

            $("#combination-name-existing").addClass('d-none')
            $("#combination-name-existing .combination_key").prop('disabled', true);

            $("#combination-name-new").removeClass('d-none');
            $("#combination-name-new .combination_key").prop('disabled', false);
         }
      });

      $('#variable-product').change(function(){
         if($(this).val() == 'yes'){
            $("#variable-product-inputs").removeClass('d-none');
            $('#variants').removeClass('d-none');
         }else{
            $("#variable-product-inputs").addClass('d-none');
            $('#variants').addClass('d-none');
            
            $("[name='attribute_id']").val('');
            $("[name='attribute_id']").trigger('change');

            $("#combination").val('new');
            $("#combination").trigger('change');
         }
      });
 
   });
</script>
@endsection