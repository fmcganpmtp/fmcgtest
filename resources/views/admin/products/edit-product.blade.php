@extends('admin.master')
@section('title', 'Edit Sample Product')
@section('breadcrumb') Edit Sample Product @endsection
@section('content')




  <div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <div class="card-out mb-4 inner-form">
        <h2>Edit Sample Product </h2>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-12">
              <div class="card ">
    
              <div class="card-body">
              <div class="row">


				  
				  
				  
				  
				  <form id="formsubmit">
            <div class="row">
                        <input type="hidden" name="id" value="{{ $product->id }}">
            <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="name" >{{ __('Product Description:') }} <span class="color_red">*</span></label>

                            <div >
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $product->name }}" >

                                <span id="txtname"></span>
                            </div>
                        </div></div>
						
				<div class=" col-lg-2 col-12"> <div class="form-group">
                  <label>Currency: <sup>*</sup></label>
                 <select name="currency_id" id="currency" class="form-control  {{ $errors->has('currency_id') ? ' is-invalid' : '' }}" aria-label=""  >
                    <option value="">Select</option>
                  @if(!empty($currencies))
                  @foreach ($currencies as $currency)
                  
                    <option {{ $product->currency_id==$currency->id? 'selected':'' }}  value="{{$currency->id}}">{{$currency->shortcode}}(<?=$currency->symbol?>)</option>
                    
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
                    
                        <div class=" col-lg-4 col-12 "><div class="form-group">
                            <label for="product_price" >{{ __('Price') }} <sup id="not_man">*</sup></label>

                            <div >
                                <input id="product_price"  type="text" class="form-control{{ $errors->has('product_price') ? ' is-invalid' : '' }}" name="product_price" value="{{ $product->product_price }}" >

                                <span id="txtproduct_price"></span>
                            </div>
                        </div></div>
                        <div class=" col-lg-4 col-12 price_request_outer">
                  <div class="form-group">
                    <label for="stock_count" >{{ __('Price on Request:') }} </label>
                    <div class="form-field-style"form-field-style" >
                      <input type="checkbox" name="price_on_request" @if(strtolower(trim(old('price_on_request',$product->price_on_request)))==strtolower('Price on request'))  checked @endif   class="price_request"  value="Price on request"> {{ __('Price on Request') }} </div>
                  </div>
                </div>
                <div class=" col-lg-4 col-12 negotiable_outer">
                  <div class="form-group">
                    <label for="stock_count" >{{ __('Negotiable:') }} </label>
                    <div class="form-field-style"form-field-style" >
                      <input type="checkbox" name="price_negotiable" @if(strtolower(trim(old('price_negotiable',$product->price_negotiable)))==strtolower('Negotiable')) checked @endif   class="negotiable"  value="Negotiable"> {{ __('Negotiable') }} </div>
                  </div>
                </div>
                
                  
                  
                  <?php  $count=0; $executed1='no'; $executed2='no';  $prev_sub=[]; ?>
 @if(!empty($cat_selected)&&($cat_selected->getParentsNames()))  
@if(!is_null($cat_selected->getParentsNames()))
@foreach ($cat_selected->getParentsNames()->reverse() as $item_selected)
<?php if($count==0) {  ?>
<div class=" col-lg-6  col-12">
                <div class="form-group">
                  <label> Category: <span class="color_red">*</span></label>
                  <select type="text"   id="category" name="category_id" class="form-control" >
                                      @if($categories)
                                            @foreach($categories as $item)
                                             <option @if( $item->id==$item_selected->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                               
                                            @endforeach
                                        @endif
                                    </select>
                                                            <span id="dldcategory"></span>

                </div>
              </div>
<?php }  if($count==1) { $executed1 ='yes';  ?>
 <div class=" col-lg-6 col-12  sub_cat"  @if(empty($prev_sub->subcategory))   style="display:none;" @endif >
                <div class="form-group">
                  <label>Sub Category:</label>
                  <select name="subcategory_id" id="subcategory" class="form-control input-sm">
                   
                                           @if(!empty($prev_sub->subcategory)   )
                                           @foreach($prev_sub->subcategory as $item1)
                                           <option @if( $item1->id==$item_selected->id) selected @endif value="{{$item1->id}}">{{$item1->name}}</option>
                                           @endforeach    
                                           @else
                                            <option value=""></option>
                                           @endif
 
                  </select>
                </div>
              </div>
 <?php  }  $count++; $prev_sub=$item_selected; ?>

@endforeach  
@endif

<?php $second = '';?>
<?php if($count==1 &&  $executed1 !='yes') {  $second = 'yes'; ?>
 <div class=" col-lg-6  col-12  sub_cat"  @if(empty($prev_sub->subcategory))   style="display:none;" @endif >
                <div class="form-group">
                  <label>Sub Category:</label>
                  <select name="subcategory_id" id="subcategory" class="form-control input-sm">
                                          @if(!empty($prev_sub->subcategory)   )
                                           @foreach($prev_sub->subcategory as $item1)
                                           <option @if( $item1->id==$product->category_id) selected @endif value="{{$item1->id}}">{{$item1->name}}</option>
                                           @endforeach    
                                           @else
                                            <option value=""></option>
                                           @endif
 
                </select>
                </div>
              </div>
 <?php } if($count>=1 && $second == 'yes' || $executed1 =='yes') {  ?>
 
 
 <div class=" col-lg-6  col-12  subsub_cat"     @if( $count>=2 && $second =='yes'  || $executed1 =='yes') style="display:block;" @else style="display:none;" @endif>
                <div class="form-group">
                  <label>Sub Category:</label>
                  <?php $selectedCategories = []; ?>
                  <select name="subsubcategory_id" id="subsubcategory" class="form-control input-sm">
                                           @if(!empty($prev_sub->subcategory)   )
                                           @foreach($prev_sub->subcategory as $item1)
                                           <option @if( $item1->id==$product->category_id) selected @endif value="{{$item1->id}}">{{$item1->name}}</option>
                                           @endforeach    
 
                                           @else
                                            <option value=""></option>
                                           @endif
                  </select>
                </div>
              </div>
 <?php } ?>
@else 
<div class=" col-lg-6  col-12">
                <div class="form-group">
                  <label> Category: <span class="color_red">*</span></label>
                  <select type="text"   id="category" name="category_id" class="form-control" >
                                        <option value="">None</option>
                                        @if($categories)
                                            @foreach($categories as $item)
                                            <?php $dash=''; ?>
                                             
                                             <option @if( $item->id==$product->category_id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                               


                                            @endforeach
                                        @endif
                                    </select>
                   <span id="dldcategory"></span>

                </div>
              </div>
 <div class=" col-lg-6  col-12  sub_cat" style="display:none;">
                <div class="form-group">
                  <label>Sub Category:</label>
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

@endif  
                  
                  
                  
                  
                  
                        
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="SKU" >{{ __('SKU:') }} </label>
 
                            <div >
                                <input id="SKU" type="text" class="form-control{{ $errors->has('SKU') ? ' is-invalid' : '' }}" name="SKU" value="{{ $product->SKU }}" >

                            </div>
                        </div></div>
                        
                         <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="EAN_GTIN" >{{ __('EAN/GTIN:') }} </label>
 
                            <div >
                                <input id="EAN_GTIN" type="text" class="form-control" name="EAN_GTIN" value="{{ $product->EAN_GTIN }}" >

                            </div>
                        </div></div>
                         <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="batch" >{{ __('Batch#:') }} </label>
 
                            <div >
                                <input id="batch" type="text" class="form-control" name="batch" value="{{ $product->batch }}" >

                            </div>
                        </div></div>
                         <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="pcsbox" >{{ __('Pcs/Box:') }} </label>
 
                            <div >
                                <input id="pcsbox" type="text" class="form-control{{ $errors->has('pcs_box') ? ' is-invalid' : '' }}" name="pcs_box" value="{{ $product->pcs_box }}" >

                                @if ($errors->has('pcs_box'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('pcs_box') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                        
                         <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="pcspallet" >{{ __('Pcs/Pallet:') }} </label>
 
                            <div >
                                <input id="pcspallet" type="text" class="form-control{{ $errors->has('pcs_pallet') ? ' is-invalid' : '' }}" name="pcs_pallet" value="{{ $product->pcs_pallet }}" >

                                @if ($errors->has('pcs_pallet'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('pcs_pallet') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                         <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="boxpallet" >{{ __('Box/Pallet:') }} </label>
 
                            <div >
                                <input id="boxpallet" type="text" class="form-control{{ $errors->has('box_pallet') ? ' is-invalid' : '' }}" name="box_pallet" value="{{ $product->box_pallet }}" >

                                @if ($errors->has('box_pallet'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('box_pallet') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                         <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="leadtime" >{{ __('Lead Time:') }} </label>
 
                            <div >
                                <input id="leadtime" type="text" class="form-control{{ $errors->has('leadtime') ? ' is-invalid' : '' }}" name="leadtime" value="{{ $product->leadtime }}" >

                                @if ($errors->has('leadtime'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('leadtime') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                       
                        
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="feature" >{{ __('Brand:') }} </label>
 
                            <div >
                                <input type="text" class="form-control {{ $errors->has('brands') ? ' is-invalid' : '' }}" name='brands' value="{{ $product_brand ?? '' }}"  >
                                
                            </div>
                        </div></div>
                        
                        
       <!--                 <div class=" col-lg-6 col-12"><div class="form-group">-->
       <!--                     <label for="feature" >{{ __('Feature:') }} </label>-->
 
       <!--                     <div >-->
       <!--                         <input id="feature" type="text" class="form-control{{ $errors->has('feature') ? ' is-invalid' : '' }}" name="feature" value="{{ $product->feature }}" >-->

       <!--                         @if ($errors->has('feature'))-->
       <!--                             <span class="invalid-feedback" role="alert">-->
       <!--                                 <strong>{{ $errors->first('feature') }}</strong>-->
       <!--                             </span>-->
       <!--                         @endif-->
       <!--                     </div>-->
       <!--                 </div></div>-->
       <!--                    <div class=" col-lg-6 col-12"><div class="form-group">-->
       <!--                     <label for="brix" >{{ __('Brix(%):') }} </label>-->
 
       <!--                     <div >-->
       <!--                         <input id="brix" type="text"    class="form-control{{ $errors->has('brix') ? ' is-invalid' : '' }}" name="brix" value="{{ $product->brix }}" >-->

       <!--                         @if ($errors->has('brix'))-->
       <!--                             <span class="invalid-feedback" role="alert">-->
       <!--                                 <strong>{{ $errors->first('brix') }}</strong>-->
       <!--                             </span>-->
       <!--                         @endif-->
       <!--                     </div>-->
       <!--                 </div></div>-->
						 <!--<div class=" col-lg-6 col-12"><div class="form-group">-->
       <!--                     <label for="packaging" >{{ __('Packaging:') }} </label>-->
 
       <!--                     <div >-->
       <!--                         <input id="packaging" type="text" class="form-control{{ $errors->has('packaging') ? ' is-invalid' : '' }}" name="packaging" value="{{ $product->packaging }}" >-->

       <!--                         @if ($errors->has('packaging'))-->
       <!--                             <span class="invalid-feedback" role="alert">-->
       <!--                                 <strong>{{ $errors->first('packaging') }}</strong>-->
       <!--                             </span>-->
       <!--                         @endif-->
       <!--                     </div>-->
       <!--                 </div></div>-->
						<div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="place_of_origin" >{{ __('Place Of Origin:') }} </label>
 
                            <div >
                                <input id="place_of_origin" type="text" class="form-control{{ $errors->has('place_of_origin') ? ' is-invalid' : '' }}" name="place_of_origin" value="{{ $product->place_of_origin }}" >

                                @if ($errors->has('place_of_origin'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('place_of_origin') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						<!--<div class=" col-lg-6 col-12"><div class="form-group">-->
      <!--                      <label for="model_number" >{{ __('Model Number:') }} </label>-->
 
      <!--                      <div >-->
      <!--                          <input id="model_number" type="text" class="form-control{{ $errors->has('model_number') ? ' is-invalid' : '' }}" name="model_number" value="{{ $product->model_number }}" >-->

      <!--                          @if ($errors->has('model_number'))-->
      <!--                              <span class="invalid-feedback" role="alert">-->
      <!--                                  <strong>{{ $errors->first('model_number') }}</strong>-->
      <!--                              </span>-->
      <!--                          @endif-->
      <!--                      </div>-->
      <!--                  </div></div>-->
						<!--  <div class=" col-lg-6 col-12"><div class="form-group">-->
      <!--                      <label for="primary_ingredients" >{{ __('Primary Ingredients:') }} </label>-->
 
      <!--                      <div >-->
      <!--                          <input id="primary_ingredients" type="text" class="form-control{{ $errors->has('primary_ingredients') ? ' is-invalid' : '' }}" name="primary_ingredients" value="{{ $product->primary_ingredients }}" >-->

      <!--                          @if ($errors->has('primary_ingredients'))-->
      <!--                              <span class="invalid-feedback" role="alert">-->
      <!--                                  <strong>{{ $errors->first('primary_ingredients') }}</strong>-->
      <!--                              </span>-->
      <!--                          @endif-->
      <!--                      </div>-->
      <!--                  </div></div>-->
						<!--<div class=" col-lg-6 col-12"><div class="form-group">-->
      <!--                      <label for="additives" >{{ __('Additives:') }} </label>-->
 
      <!--                      <div >-->
      <!--                          <input id="additives" type="text" class="form-control{{ $errors->has('additives') ? ' is-invalid' : '' }}" name="additives" value="{{ $product->additives }}" >-->

      <!--                          @if ($errors->has('additives'))-->
      <!--                              <span class="invalid-feedback" role="alert">-->
      <!--                                  <strong>{{ $errors->first('additives') }}</strong>-->
      <!--                              </span>-->
      <!--                          @endif-->
      <!--                      </div>-->
      <!--                  </div></div>-->
						<!--<div class=" col-lg-6 col-12"><div class="form-group">-->
      <!--                      <label for="flavor" >{{ __('Flavor:') }} </label>-->
 
      <!--                      <div >-->
      <!--                          <input id="flavor" type="text" class="form-control{{ $errors->has('flavor') ? ' is-invalid' : '' }}" name="flavor" value="{{ $product->flavor }}" >-->

      <!--                          @if ($errors->has('flavor'))-->
      <!--                              <span class="invalid-feedback" role="alert">-->
      <!--                                  <strong>{{ $errors->first('flavor') }}</strong>-->
      <!--                              </span>-->
      <!--                          @endif-->
      <!--                      </div>-->
      <!--                  </div></div>-->
						<!-- <div class=" col-lg-6 col-12"><div class="form-group">-->
      <!--                      <label for="certification" >{{ __('Certification:') }} </label>-->
 
      <!--                      <div >-->
      <!--                          <input id="certification" type="text" class="form-control{{ $errors->has('certification') ? ' is-invalid' : '' }}" name="certification" value="{{ $product->certification }}" >-->

      <!--                          @if ($errors->has('certification'))-->
      <!--                              <span class="invalid-feedback" role="alert">-->
      <!--                                  <strong>{{ $errors->first('certification') }}</strong>-->
      <!--                              </span>-->
      <!--                          @endif-->
      <!--                      </div>-->
      <!--                  </div></div>-->
						<!--<div class=" col-lg-6 col-12"><div class="form-group">-->
      <!--                      <label for="volume" >{{ __('Volume:') }} </label>-->
 
      <!--                      <div >-->
      <!--                          <input id="volume" type="text" class="form-control{{ $errors->has('volume') ? ' is-invalid' : '' }}" name="volume" value="{{ $product->volume }}" >-->

      <!--                          @if ($errors->has('volume'))-->
      <!--                              <span class="invalid-feedback" role="alert">-->
      <!--                                  <strong>{{ $errors->first('volume') }}</strong>-->
      <!--                              </span>-->
      <!--                          @endif-->
      <!--                      </div>-->
      <!--                  </div></div>-->
						<!--<div class=" col-lg-6 col-12"><div class="form-group">-->
      <!--                      <label for="BBD" >{{ __('BBD:') }} </label>-->
 
      <!--                      <div >-->
      <!--                          <input id="BBD" type="text" class="form-control{{ $errors->has('BBD') ? ' is-invalid' : '' }}" name="BBD" value="{{ $product->BBD }}" >-->

      <!--                          @if ($errors->has('BBD'))-->
      <!--                              <span class="invalid-feedback" role="alert">-->
      <!--                                  <strong>{{ $errors->first('BBD') }}</strong>-->
      <!--                              </span>-->
      <!--                          @endif-->
      <!--                      </div>-->
      <!--                  </div></div>-->
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="stock_count" >{{ __('Stock:') }} </label>
 
                            <div >
                          
                             <input type="checkbox" name="unlimited_stock" @if(strtolower(trim(old('unlimited_stock',$product->unlimited_stock)))==strtolower('Unlimited')) checked @endif  class="unlimited" value="Unlimited"> {{ __('Unlimited Stock') }}
                            </div>
                        </div></div>
						          
						            <div class=" col-lg-6 col-12 stk_cnt"><div class="form-group">
                            <label for="stock_count" >{{ __('Available Stock:') }} </label>
 
                            <div >
                                <input id="stock_count" type="text" class="form-control{{ $errors->has('stock_count') ? ' is-invalid' : '' }}" name="stock_count" value="{{ $product->stock_count??'' }}"  >

                                @if ($errors->has('stock_count'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('stock_count') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						         
						<!--<div class=" col-lg-6 col-12"><div class="form-group">-->
      <!--                      <label for="product_color" >{{ __('Product Color:') }}</label>-->
 
      <!--                      <div >-->
      <!--                          <input id="product_color" type="text" class="form-control{{ $errors->has('product_color') ? ' is-invalid' : '' }}" name="product_color" value="{{ $product->product_color }}"  >-->

      <!--                          @if ($errors->has('product_color'))-->
      <!--                              <span class="invalid-feedback" role="alert">-->
      <!--                                  <strong>{{ $errors->first('product_color') }}</strong>-->
      <!--                              </span>-->
      <!--                          @endif-->
      <!--                      </div>-->
      <!--                  </div></div>-->
						
						<div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_weight" >{{ __('Product Weight/Size:') }} </label>
 
                            <div >
                                <input id="product_weight" type="text" class="form-control{{ $errors->has('product_weight') ? ' is-invalid' : '' }}" name="product_weight" value="{{  $product->product_weight ?? $product->product_size ?? '' }}"  >

                                @if ($errors->has('product_weight'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_weight') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
						
						<!--<div class=" col-lg-6 col-12"><div class="form-group">-->
      <!--                      <label for="product_size" >{{ __('Size:') }} </label>-->
 
      <!--                      <div >-->
      <!--                          <input id="product_size" type="text" class="form-control{{ $errors->has('product_size') ? ' is-invalid' : '' }}" name="product_size" value="{{ $product->product_size }}"  >-->

      <!--                          @if ($errors->has('product_size'))-->
      <!--                              <span class="invalid-feedback" role="alert">-->
      <!--                                  <strong>{{ $errors->first('product_size') }}</strong>-->
      <!--                              </span>-->
      <!--                          @endif-->
      <!--                      </div>-->
      <!--                  </div></div>-->
						<!--<div class=" col-lg-6 col-12"><div class="form-group">-->
      <!--                      <label for="product_dimension" >{{ __('Dimensions:') }} </label>-->
 
      <!--                      <div >-->
      <!--                          <input id="product_dimension" type="text" class="form-control{{ $errors->has('product_dimension') ? ' is-invalid' : '' }}" name="product_dimension" value="{{ $product->product_dimension }}"  >-->

      <!--                          @if ($errors->has('product_dimension'))-->
      <!--                              <span class="invalid-feedback" role="alert">-->
      <!--                                  <strong>{{ $errors->first('product_dimension') }}</strong>-->
      <!--                              </span>-->
      <!--                          @endif-->
      <!--                      </div>-->
      <!--                  </div></div>-->
						
			<!--			<div class=" col-lg-6 col-12"><div class="form-group">-->
   <!--                         <label for="variants" >{{ __('Varients:') }} </label>-->
 
   <!--                         <div >-->
   <!--                              <select type="text" multiple  name="variants[]" id='variants' class="form-control{{ $errors->has('variants') ? ' is-invalid' : '' }}">-->
   <!--      @foreach ($varients as $varient)-->
   <!--       <?php $selectedvariants = explode(",",$product->variants);?>-->
   <!--       @if(in_array($varient->id, $selectedvariants))-->
   <!--                     <option value="{{ $varient->id }}" selected="true">{{ $varient->name }}</option>-->
   <!--                     @else-->
   <!--                     <option value="{{ $varient->id }}">{{ $varient->name }}</option>-->
   <!--                     @endif -->
   <!--  @endforeach -->
		 <!--</select>-->
          
   <!--                             @if ($errors->has('variants'))-->
   <!--                                 <span class="invalid-feedback" role="alert">-->
   <!--                                     <strong>{{ $errors->first('variants') }}</strong>-->
   <!--                                 </span>-->
   <!--                             @endif-->
   <!--                         </div>-->
   <!--                     </div>-->
   <!--                 </div>-->

                     <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_expiry" >{{ __('BBD/Expiry Date:') }} </label>
 
                            <div >
                                <input id="product_expiry" type="Date" class="form-control{{ $errors->has('product_expiry') ? ' is-invalid' : '' }}" name="product_expiry" value="{{ $product->product_expiry ?? $product->BBD ?? '' }}"  >

                                @if ($errors->has('product_expiry'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_expiry') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                        
      <!--                  <div class=" col-lg-6 col-12">-->
      <!--                  @if($product_images)-->
						<!--@foreach ($product_images as $product_image)-->
      <!--                  @if($product_image->thumbnail=="yes")-->
      <!--                  <div id="image-tumb{{ $product_image->id }}">-->
      <!--                  <button type="button" class="btn text-danger" onclick="removeImage({{ $product_image->id }},'tumb',event)">X</button>-->
      <!--                  <img src="{{URL::asset('/uploads/productImages/'.'/'.$product_image->image_path)}}" class="img-responsive" style="max-height: 100px; max-width: 100px;" alt="" srcset="">-->
      <!--                  </div>-->
      <!--                  @endif-->
      <!--                  @endforeach-->
      <!--                  @endif-->
      <!--                  <div class=" col-lg-12 col-12">-->
      <!--                      <div class="form-group">-->
      <!--                      <label for="product_image" >{{ __('Thumbnail image:') }} </label>-->
      <!--                      <input type="file" id="product_image" class="form-control m-2" name="product_image" accept="image/png, image/gif, image/jpeg" >-->
                               
      <!--                          @if ($errors->has('product_image'))-->
      <!--                              <span class="invalid-feedback" role="alert">-->
      <!--                                  <strong>{{ $errors->first('product_image') }}</strong>-->
      <!--                              </span>-->
      <!--                          @endif-->
                            
      <!--                  </div>-->
      <!--              </div>-->
      <!--                  </div>-->
						
						

                        

                        <div class=" col-lg-12 col-12">
                            
                        @if($product_images)
						@foreach ($product_images as $product_image)
                        @if($product_image->thumbnail=="no" || $product_image->thumbnail=="yes")
                        <div style="float:left;"  id="image-block{{ $product_image->id }}">
                         <button type="button" class="btn text-danger" onclick="removeImage({{ $product_image->id }},'block',event)">X</button>
                         <img src="{{URL::asset('/uploads/productImages/'.'/'.$product_image->image_path)}}" class="img-responsive" style="max-height: 100px; max-width: 100px;" alt="" srcset="">
                         </div>
                         @endif
                        @endforeach
                        @endif
                        <div class=" col-lg-6 col-12"><div class="form-group"><br/>
                            <label for="product_gallery" style="clear:both;display:block;" >{{ __('Gallery Images(Multiple Upload):') }} </label>
 
                            <div >
                            <input type="file" id="product_gallery" class="form-control m-2" name="product_gallery[]" accept="image/png, image/gif, image/jpeg" multiple>
                                
                                @if ($errors->has('product_gallery'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('product_gallery') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div></div>
                        </div>


                    
                        <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="location" >{{ __('Stock Location') }} </label>

                            <div >
                                <input id="location"  type="text"  class="form-control" name="location" value="{{ $product->location }}">                            
                            </div>
                        </div>
                    </div>
                    
                    <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="location" >{{ __('Etiket / Label Language') }} </label>

                            <div >
                                <input id="label_language"  type="text"  class="form-control" name="label_language" value="{{ $product->label_language }}">                            
                            </div>
                        </div>
                    </div>


						 <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="Minimal Order" >{{ __('Minimal Order Quantity') }} </label>

                            <div >
                                <input id="minimal_order"  type="text"  class="form-control" name="minimal_order" value="{{ old('minimal_order',$product->minimal_order) }}">                            
                            </div>
                        </div>
                    </div>
                     <div class=" col-lg-6 col-12"><div class="form-group">
                            <label for="product_condition" >{{ __('Product Condition') }} </label>

                            <div >

                              
                               
                                <select class="form-control" name="product_condition" >
                                    <option value="" {{$product->product_condition=='' ? 'selected' : ''}}>Select</option>
                                    <option value="New" {{$product->product_condition=='New' ? 'selected' : ''}}>New</option>
                                    <option value="Used"  {{$product->product_condition=='Used' ? 'selected' : ''}}>Used</option>
                                    <option value="Refurbished" {{$product->product_condition=='Refurbished' ? 'selected' : ''}}>Refurbished</option>
                                    <option value="Damaged"  {{$product->product_condition=='Damaged' ? 'selected' : ''}}>Damaged</option>
                                </select>                        
                            </div>
                        </div>
                    </div>
						
                        
						
						
					<!--	<div class=" col-lg-6 col-12"><div class="form-group">-->
     <!--                       <label for="available_countries" >{{ __('Available Countries:') }} </label>-->
 
     <!--                       <div >-->
     <!--                           <select type="text" multiple placeholder="Available Countries" name="available_countries[]" id='available_countries' class="form-control{{ $errors->has('product_dimension') ? ' is-invalid' : '' }}">-->
     <!--                           @foreach ($countries as $country)-->
     <!--                           <?php $selectedCountries = explode(",",$product->available_countries);?>-->
     <!--                           @if(in_array($country->id, $selectedCountries))-->
                               
     <!--                   <option value="{{ $country->id }}" selected="true" />{{ $country->name }}</option>-->
     <!--                   @else-->
     <!--                   <option value="{{ $country->id }}">{{ $country->name }}</option>-->
     <!--                   @endif -->
     <!--@endforeach -->
     <!--                           </select>-->
     <!--                           @if ($errors->has('available_countries'))-->
     <!--                               <span class="invalid-feedback" role="alert">-->
     <!--                                   <strong>{{ $errors->first('available_countries') }}</strong>-->
     <!--                               </span>-->
     <!--                           @endif-->
     <!--                       </div>-->
     <!--                   </div></div>-->
						
						<div class=" col-lg-12 col-12"><div class="form-group">
                            <label for="product_description" >{{ __('Description') }}</label>

                            <div >
                             
                               <textarea name="product_description" id="mytextarea" style="height:300px !important;" class="form-control{{ $errors->has('product_description') ? ' is-invalid' : '' }}" >{{ $product->product_description }}</textarea>
                               
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
                                    {{ __('Update') }}
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
<script src="{{asset('/admin1/js/select2.min.js')}}"></script>
<script src="{{asset('/admin1/js/sweetalert.js')}}"></script>
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
  
$("#formsubmit").on('submit', function(e) {
            $(".loaderajax").show();
            tinymce.triggerSave();
            e.preventDefault();
            var formData = new FormData($('#formsubmit')[0]);
           formData.append('_token', "{{ csrf_token() }}"); 

                $.ajax({
                type: "post",
                url: "{{ route('update.product') }}",
                data: formData,
                enctype : 'multipart/form-data',
                dataType: "json",
                processData: false,
                contentType: false,
                success: function(data) {
                    $(".loaderajax").hide();
                    swal(data, "", "success");
                    $(window).scrollTop(0);
                    var url1="{{route('list-products')}}";
                    setTimeout(window.location.href=url1,300);
                },
                error: function (xhr) {
                    $(".loaderajax").hide();
                    var errors = JSON.parse(xhr.responseText);  
                    if(errors.errors.name)
                    $("#txtname").empty().append("<p style='color:red'>"+errors.errors.name[0]+"</p>");
                    else
                      $("#txtname").empty();
                    if(errors.errors.product_price)
                    $("#txtproduct_price").empty().append("<p style='color:red'>"+errors.errors.product_price[0]+"</p>");
                    else
                      $("#txtproduct_price").empty();
                    
                    if(errors.errors.category_id)
                        $("#dldcategory").empty().append("<p style='color:red'>"+errors.errors.category_id[0]+"</p>");
                      else
                        $("#dldcategory").empty();
                    if(errors.errors.stock_count)
                    $("#txtstock_count").empty().append("<p style='color:red'>"+errors.errors.stock_count[0]+"</p>");
                    else
                      $("#txtstock_count").empty();
                    if(errors.errors.product_image)
                        $("#txtproduct_image").empty().append("<p style='color:red'>"+errors.errors.product_image[0]+"</p>");
                    else
                       $("#txtproduct_image").empty();

                  
                    $(window).scrollTop(0);
                               
                }
            });
          });   
   
var route = "{{route('available.countries')}}";
  $('#available_countries').select2({
     placeholder: 'Select Available Countries',

    
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

  function removeImage(id = 0,type,event){ 

   
          swal({
        title: "Are you Sure you want to  Remove Image?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
               if(id != 0){
                    $.ajax({
                        type:'post',
                        url:'{{route("delete.productImage")}}',
                        data:{id: id, '_token':'{{csrf_token()}}'},
                        success:function(response){
                            if(response=='true')            
                                $('#image-'+type+id).remove();
                             else 
                                  swal(response.message,'', "success"); 
                               
                            
                        }
                    });
                } else 
                   swal('Image remove failed. Something went wrong.', "", "error");
                   
                
            }
        });
  }
</script>





<script type="text/javascript">
$(document).ready(function () {
     var unlimited_stock='<?php echo $product->unlimited_stock;?>';

      if(unlimited_stock=='Unlimited')
        $(".stk_cnt").hide();
      else
        $(".stk_cnt").show();

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







            $('#category').on('change',function(e){
            console.log(e);
            var cat_id = e.target.value;
            var bse_url = "{{URL::to('/')}}";
            $.get(bse_url+'/ajax-subcat?cat_id='+ cat_id,function(data){
$('#subsubcategory').empty();
$('.subsub_cat').hide();
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