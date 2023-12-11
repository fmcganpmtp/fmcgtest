@extends('layouts.template')
@section('title', 'Product Listing')
@section('content')

<!-- Start Page Title Area -->
<div class="page-title-area">
  <div class="container">
    <div class="page-title-content">
      <ul>
        <li><a href="{{ route('home')}}"> Home</a></li>
        <li class="active">{{$search_key}}</li>
      </ul>
    </div>
  </div>
</div>
<!-- Start Product Area -->
<section class="products-area ptb-54 innerpageC">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <div class="widget-sidebar mr-15">
          @if (in_array("Keywords", $search_conditions))
          <div class="sidebar-widget categories">
            <ul>
              <li>
                <h3>Search by Keyword</h3>
              </li>
            </ul>
                <div class="autocomplete form-group sg-list" >
                <input type="text" name="keyword" id='search_keyword' class="form-control"  placeholder="Type Here...">
                <input type="hidden" name="topcategorysearch" id='topcategorysearch' value="{{$search_key}}">
                        <!-- <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button> -->
            </div>
          </div>
          @endif
         @if (in_array("Category", $search_conditions))
             @if(count($left_menu_list)>0)
                <div class="sidebar-widget categories">
                  <ul id="ulcatgory">
                    <li><h3>Categories</h3></li>
                    @foreach($left_menu_list as $data)
                    <li><input type="checkbox" class="chkcategory"  onclick="fnPushcategoryId({{$data['id']}})" value="{{$data['id']}}"> &nbsp;&nbsp;{{$data['name']}}</li>
                    @endforeach
                  </ul>
                </div>
               @endif
          @endif

            @if (in_array("Price filter", $search_conditions))
          <div class="sidebar-widget filter price-ranger01">
            <h3>Filter By Price</h3>
           
          
                   <input type="text" class="js-range-slider" name="my_range" value="" data-skin="round" data-type="double" data-min="0" data-max={{$max_product_price}} data-grid="false"/>
                   
                   
                   <div class="row price-fliter-Box">
                   
                   <div class="col-lg-6 col-12">
                   <label>Price From :</label>
                   <input type="text"  placeholder="0" onblur="range_selfupdate()" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="price_from"  />
                  </div>
                  
                  <div class="col-lg-6 col-12">
                   <label>Price To :</label>
                   <input type="text"  placeholder="{{$max_product_price}}" onblur="range_selfupdate()"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="price_to" />  
          
           </div>
          </div>
          
          
          
          </div>

            @endif

          @if (in_array("Brand", $search_conditions))
           @if(count($brand_lists)>0)
               <div class="sidebar-widget brand">
                  <h3>Brand</h3>
                  <ul id="ulbrands">
                    @foreach($brand_lists as $data)
                    <li><input type="checkbox" class="chkbrand" onclick="fnPushBrandId({{$data['id']}})" value="{{$data['id']}}"> &nbsp;&nbsp;{{$data['name']}} ({{$data['count']}})</li>
                    @endforeach
                    </ul>
                </div>
            @endif
           @endif

              @if (in_array("Country", $search_conditions))
          <div class="sidebar-widget categories dontclosecategories">
            <ul>
              <li>
                <h3>Country</h3>
              </li>
            </ul>
            <div class="autocomplete form-group sg-list" >
      
              <select type="text" placeholder="Available Countries" name="available_countries[]" id='available_countries' class="form-control{{ $errors->has('product_dimension') ? ' is-invalid' : '' }}" multiple="multiple">
              </select>
              <input type="hidden" id="selected_country_id">
              <input type="hidden" id="start_from" value="0">
              <!--<button type="button"><i class="fa fa-search" aria-hidden="true"></i></button>-->
            </div>
          </div>

     @endif 
       @if (in_array("Product status", $search_conditions))
          @if(count($Trendingproducts)>0)     
          <div class="trendingss">
            <ul class="trending-product-list">
              <li>
                <h3>Trending Products</h3>
              </li>
            
              @foreach($Trendingproducts as $product)
             <?php 
             $image=$product->sellerproductimage;
              $image_path='/images/no-image.jpg';
            foreach( $image as $data){  
              if($data->thumbnail=='yes')  $image_path='/uploads/productImages/'.$data->image_path;}?>

              <li class="single-list"> <div class="single-list-img"><img src="{{URL::asset($image_path)}}" alt="Image"></div>
                <div class="product-content"> <a href="{{ route('view.Sproduct',$product->id)}}" class="title"> {{ ucfirst($product->name) ?? ""}} </a>
                  <ul class="products-price">
                       @if($validity )
                    <li> <?php  echo !empty($product->Currency->symbol) ? $product->Currency->symbol : '$' ?> {{ number_format($product->product_price,3) }} </li>
                    @endif
                  </ul>
                </div>
              </li>
              @endforeach
             </ul>
          </div>
           @endif
          @endif 
        </div>
      </div>


      <div class="col-lg-9 col-12">

        @if(count($central_listing)>0) 
            <div class="row"  id="divsubcategory">
                <div class="col-lg-12">
                  <div class="top-cat-bx">
                      <ul id="subcategory">
                         @foreach($central_listing as $val)
                            <li><a href="javascript:void(0)" onclick="fnsubcategory({{$val['id']}})">{{$val['name']}}</a></li>
                         @endforeach
                        </ul>
                    </div>
                </div>
            </div> 
        @endif

        <div class="row" id="product_list"> </div>  
        <div class="default-btn load-btn" style="display: none;" id="loadmore" onclick="loadmore()">Load More...</div> 
      </div>
    </div>
  </div>
</section>
<style>

.load-btn{ display: table;
margin:10px auto;
cursor:pointer;}
 </style>

<!-- End Product Area -->
<!-- End Subscribe  Area -->

<?php $searchTop = request()->searchTop;?>
<script src="{{ asset('js/jquery.min.js')}}"></script>
<script src="{{ asset('js/io_range-slider.min.js')}}"></script>
<link rel="stylesheet" href="{{ asset('/css/io_rangeslider.css')}}"> 
<link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">
<script src="{{ asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
var jquery=$;
var range_value="0-"+'<?=$max_product_price;?>';
var $range = jquery(".js-range-slider"),
    range,
    from,
    to;
var type_searchby_text='<?=$type_searchby_text?>';
function range_selfupdate()
{
    var val1 =parseInt(jquery(".price_from").val());
    var val2 = parseInt(jquery(".price_to").val());
    if(val1<=val2)
    {
        var max='<?=$max_product_price;?>';
        if(val2>max)
        {
            val1=0;
            val2=max;
            jquery(".price_from").val('');
            jquery(".price_to").val('');
        } 
        range_value=Math.trunc(val1)+"-"+Math.trunc(val2) ; 
        updateRange(val1,val2);
        jquery('#start_from').val(0);
        jquery("#product_list").empty();
        product_search(); 
                  
    }
    else if(val1>val2)
    {
     var val2='<?=$max_product_price;?>';
     jquery(".price_from").val('');
     jquery(".price_to").val('');
      updateRange(0,val2);
    }

}
var updateRange = function (val1,val2) {
    range.update({
        from: val1,
        to: val2
    });
}

jquery(document).ready(function () {
    
  var updateValues = function () {
    $from.prop("value", from);
    $to.prop("value", to);
};

$range.ionRangeSlider({
    onFinish: function (data) {

      range_value=Math.trunc(data.from)+"-"+Math.trunc(data.to) ; 
      jquery(".price_from").val(data.from);
      jquery(".price_to").val(data.to);
      jquery('#start_from').val(0);
      jquery("#product_list").empty();
      product_search();   
  }
});
 range = $range.data("ionRangeSlider"); 

  jquery("#loadmore").hide(); 
  var route = "{{route('available.countries')}}";
  jquery('#available_countries').select2({
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
          results: jquery.map(data, function(item) {
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
  }).on("change", function (e) {
     jquery("#selected_country_id").val($(this).val());
     jquery("#product_list").empty();
     jquery('#start_from').val(0);
     product_search();
    });;


});
</script>


<script type="text/javascript">
  var brand_id=[];
  var category_id=[];
  var topsubcategory_flag=false;
  $(document).ready(function(){
            product_search();

             $('#search_keyword').keydown(function (e) {
               if (e.keyCode == 13)
                {
                      $('#start_from').val(0);
                      $("#product_list").empty();
                      product_search();
                }
            })
           
            


            $(document).on("keydown", disableButtonsDown);
});

function disableButtonsDown(e) { 
    if(e.key=='F5'){
        location.reload(true);
       $("input:checkbox").prop('checked',false);
       category_id=[];
       brand_id=[];
      $('#start_from').val(0);
      
}
};



function fnPushBrandId(id){
  $('#start_from').val(0);
  var exists = brand_id.includes(id)

  if (exists) 
    brand_id= brand_id.filter((c) => { return c !== id })
  else
    brand_id.push(id)
 $("#product_list").empty();
 
  product_search();
}
function loadmore(){
     product_search();
}



function fnsubcategory(val){
    topsubcategory_flag=true;
    category_id=[];
    $('.chkcategory').prop('checked', false);
    category_id.push(val);
    $('#start_from').val(0);
    $("#product_list").empty();
    product_search();
}

function fnPushcategoryId(id){
  $('#start_from').val(0);
  
  if(topsubcategory_flag==true)
  {  
    category_id=[];
    topsubcategory_flag=false;
  }
  var exists = category_id.includes(id)

  if (exists) 
      category_id= category_id.filter((c) => { return c !== id })
  else
    category_id.push(id)
 
  console.log(category_id)
   $("#product_list").empty();
   
  product_search();
}

function product_search(){
  var brand_id_list=brand_id.join();
  var category_id_list=category_id.join();
  var selected_country_id=$("#selected_country_id").val();
  $.ajax({
                            type : 'post',
                            url:"{{route('extended_id.search')}}",
                            async: false,
                            data:{
                              _token:'{{ csrf_token() }}',
                              'brand_id':brand_id_list,
                              'category_id':category_id_list,
                              'header_search_key':'{{$search_key}}',
                              'country_id':selected_country_id,
                              'price_range':range_value,
                              'search':$('#search_keyword').val(),
                              'type_searchby_text':type_searchby_text,
                              'start_from':$('#start_from').val(),
                              'topcategorysearch':$('#topcategorysearch').val(),
                              'per_page':15
                            },
                            success:function(data)
                            {
                                  
                                  let dataItems = JSON.parse(data);
                                    

                                  var app_path="<?php echo url('seller-product-detail/')?>";

                                   var initial=0;
                                   dataItems.product_data.map((item) => {
                                    initial++;
                                    productflag=true;
                                   var string= '<div class="col-lg-4 col-12 wow fadeInUp pr-list"><a  href="'+app_path+'/'+item.product_id;
                                   string+='"> <div class="product-thumbnail hovereffect"><div class="pro-img"><img src="'+item.product_thumbnail;
                                   string+='"></div><div class="product-title"> <h3>';
                                   string+=item.product_name+' </h3>';
                                  
                               
 <?php if(Auth::guard('user')->check()) { ?>
                  
                                   if(item.available_countries!='*****' ) {
                                    string+='<h4>'+item.price+'  </h4>';
                                    string+='<div class="pro-no-loc">';
                                   var country_list='';
                                   var country=item.available_countries;
                                    if(item.available_countries!=null){
                                   country_list='<h5><i class="fa fa-map-marker" aria-hidden="true"></i>'+item.available_countries;
                                   
                                  country_list+='</h5>';
                                    }
                                  string+=country_list+'</div>';
                                }
                  
              <?php } ?>        
                  
                  
                  

                                  string+='</div></div></a></div>'
                                   
                                   $("#product_list").append(string);
                                })
                                var img_path="<?php echo asset('/uploads/defaultImages/no-image.jpg')?>";  

                                var content=$("#product_list div").length; 
                                if(content==0)
                                      $("#product_list").append('<img style="width:50%;height:auto;margin:0px auto; display:table;" src="'+img_path+'"/>');

                                var skipcount=parseInt($("#start_from").val())+ initial ;
                                if(dataItems.count!=skipcount)
                                      $("#loadmore").show();
                                else
                                      $("#loadmore").hide();

                                if(dataItems.product_data.length==0)
                                      $("#loadmore").hide();

                                $("#start_from").val(skipcount);
         
                                   
                            }
                      });

}

</script>

            

@endsection
@section('footer_script')




@endsection