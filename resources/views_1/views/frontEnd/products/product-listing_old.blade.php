@extends('layouts.template')
@section('title', 'Product Listing')
@section('content')

<!-- Start Page Title Area -->
<div class="page-title-area">
  <div class="container">
    <div class="page-title-content">
      <ul>
        <li> <a href="{{ route('home')}}"> Home </a> </li>
        <li class="active">Products</li>
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
                <h3>Search by key word</h3>
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
          <div class="sidebar-widget categories">
            <ul id="ulcatgory"></ul>
          </div>
          @endif

            @if (in_array("Price filter", $search_conditions))
          <div class="sidebar-widget filter price-ranger01">
            <h3>Filter By Price</h3>
           
            
            <p>
           <div class="price-input">
        <div class="field">
          <span>Min</span>
          <input type="number" id="txtmin" class="input-min" value="0"> 
        </div>
        <div class="separator">-</div>
        <div class="field">
          <span>Max</span>
          <input type="number"  id="txtmax" class="input-max" value="10000">
        </div>
      </div>
      <div class="slider">
        <div class="progress"></div>
      </div>
      <div class="range-input">
        <input type="range" class="range-min" min="0" max="10000" id="range_min" value="0" step="1">
        <input type="range" class="range-max" min="0" max="10000" id="range_max" value="10000" step="1">
      </div>
            </p>
          </div>

            @endif

              @if (in_array("Brand", $search_conditions))
         <div class="sidebar-widget brand">
            <h3>Brand</h3>
            <ul id="ulbrands"></ul>
          </div>
           @endif

              @if (in_array("Country", $search_conditions))
          <div class="sidebar-widget categories">
            <ul>
              <li>
                <h3>Country</h3>
              </li>
            </ul>
            <div class="autocomplete form-group sg-list" >
      
<select type="text" placeholder="Available Countries" name="available_countries[]" id='available_countries' class="form-control{{ $errors->has('product_dimension') ? ' is-invalid' : '' }}">
</select>
<input type="hidden" id="selected_country_id">
<input type="hidden" id="start_from" value="0">
              <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
          </div>

     @endif 
       @if (in_array("Product status", $search_conditions))     
          <div class="trendingss">
            <ul class="trending-product-list">
              <li>
                <h3>Trending Products</h3>
              </li>
              @if(!empty($Trendingproducts))
              @foreach($Trendingproducts as $product)
             <?php 
             $image=$product->sellerproductimage;
              $image_path='/images/no-image.jpg';
            foreach( $image as $data)
            {
              if($data->thumbnail=='yes')
                $image_path='/uploads/productImages/'.$data->image_path;
            }

             ?>
              <li class="single-list"> <img src="{{URL::asset($image_path)}}" alt="Image">
                <div class="product-content"> <a href="{{ route('view.Sproduct',$product->id)}}" class="title"> {{ ucfirst($product->name) ?? ""}} </a>
                  <ul class="products-price">
                    <li> {{$product->product_price}} </li>
                  </ul>
                </div>
              </li>
              @endforeach
              @endif
            </ul>
          </div>
           @endif 
        </div>
      </div>


      <div class="col-lg-9 col-12">
          <div class="row" style="display:none" id="divsubcategory">
        <div class="col-lg-12">
          <div class="top-cat-bx">
              <ul id="subcategory">  </ul>
            </div>
        </div>
      </div> 
        <div class="row" id="product_list"> </div>  
        <div class="default-btn load-btn" id="loadmore" onclick="loadmore()">Load More...</div> 
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


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">
<script src="{{ asset('js/select2.min.js')}}"></script>

<script type="text/javascript">


 var jquery=$;
jquery(document).ready(function () {
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
     jquery('#search_keyword').val('');
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
$(document).ready(function(){
            product_search();

             $('#search_keyword').keydown(function (e) {
                if (e.keyCode == 13) {
                    $("input:checkbox").prop('checked',"");
                $('#start_from').val(0);
                 $("#product_list").empty();
               product_search();
                }
            })
           
            $("#range_min,#range_max,#txtmax,#txtmin").change(function(){
              $('#search_keyword').val('');
              $('#start_from').val(0);
              $("#product_list").empty();
              product_search();
            });


            $(document).on("keydown", disableButtonsDown);
});

function disableButtonsDown(e) { 
    if(e.key=='F5'){
       $("input:checkbox").prop('checked',"");
        $('#start_from').val(0);
      }
};

function fnPushcategoryId(id){
  $('#search_keyword').val('');
  $('#start_from').val(0);
   category_id=[];
  var exists = category_id.includes(id)

  if (exists) 
    category_id= category_id.filter((c) => { return c !== id })
   else
    category_id.push(id)
 
  //console.log(category_id)
   $("#product_list").empty();
   load_sub_category();
  product_search();
}

function fnPushBrandId(id){
  $('#search_keyword').val('');
  $('#start_from').val(0);
  var exists = brand_id.includes(id)

  if (exists) 
    brand_id= brand_id.filter((c) => { return c !== id })
   else
    brand_id.push(id)
 $("#product_list").empty();
 load_sub_category();
  product_search();
}
function loadmore(){
  product_search();
}

function load_sub_category(){
    // var category_id_list=category_id.join();
    // $("#subcategory").empty();
    // $.ajax({
    //                         type : 'post',
    //                         url:"{{route('loadsubcategory')}}",
    //                           async: false,
    //                         data:{
    //                           _token:'{{ csrf_token() }}',
    //                           'category_id':category_id_list,
    //                          },
    //                         success:function(data)
    //                         { 
                               
    //                         }
    //       });

}

function fnsubcategory(val){
  category_id=[];
   $("input:checkbox").prop('checked',"");
  category_id.push(val);
  $('#start_from').val(0);
 $("#product_list").empty();
 product_search();
}

function product_search(){
  var brand_id_list=brand_id.join();
  var category_id_list=category_id.join();
  var selected_country_id=$("#selected_country_id").val();
  var range_value=$("#range_min").val()+"-"+$("#range_max").val() ; 
  
  $.ajax({
                            type : 'post',
                            url:"{{route('extended_id.search')}}",
                            async: false,
                            data:{
                              _token:'{{ csrf_token() }}',
                              'brand_id':brand_id_list,
                              'category_id':category_id_list,
                              'country_id':selected_country_id,
                              'price_range':range_value,
                              'search':$('#search_keyword').val(),
                              'start_from':$('#start_from').val(),
                              'topcategorysearch':$('#topcategorysearch').val(),
                              'per_page':15
                            },
                            success:function(data)
                            {
                                  
                                   let dataItems = JSON.parse(data);

                                  
                                   $("#ulcatgory").empty().append('');
                                   var ulcategorylist="";

                                    dataItems.left_menu_list.map((item) => {                                 

                                     ulcategorylist+='<li><input type="checkbox"  onclick="fnPushcategoryId('+item['id']+')" value="'+item['id']+'"> &nbsp;&nbsp;'+item['name']+'</li>';
                                   })
                                  $("#ulcatgory").append('<li><h3>Categories</h3></li>').append(ulcategorylist); 



                                     $("#ulbrands").empty();
                                   var ulbrandlist="";

                                    dataItems.brand_list.map((item) => {                                 

                                     ulbrandlist+='<li><input type="checkbox" class="chb2" onclick="fnPushBrandId('+item['id']+')">'+item['name']+'</li>';
                                   })
                                  $("#ulbrands").append(ulbrandlist); 

                                 


                                  var subcategoryflag=productflag=false;
                                  $("#subcategory").empty();
                                   var subcategory="";

                                    dataItems.central_listing.map((item) => {                                 
                                      subcategoryflag=true;
                                     subcategory+='<li><a href="javascript:void(0)" onclick="fnsubcategory('+item['id']+')">'+item['name']+'</a></li>';
                                   })
                                  $("#subcategory").append(subcategory); 

                                   if(subcategoryflag==true)
                                      $("#divsubcategory").show();
                                   else
                                      $("#divsubcategory").hide(); 

                                    

                                    var app_path="<?php echo url('seller-product-detail/')?>";

                                   var initial=0;
                                   dataItems.product_data.map((item) => {
                                    initial++;
                                    productflag=true;
                                   var string= '<div class="col-lg-4 col-12 wow fadeInUp pr-list"><a  href="'+app_path+'/'+item.product_id;
                                   string+='"> <div class="product-thumbnail hovereffect"><div class="pro-img"><img src="'+item.product_thumbnail;
                                   string+='"></div><div class="product-title"> <h3>';
                                   string+=item.product_name+' </h3><h4><i class="fa fa-usd" aria-hidden="true"></i>';
                                   string+=item.price+'  </h4><div class="pro-no-loc"> <h5><i class="fa fa-shopping-cart" aria-hidden="true"></i>';
                                   string+=item.stock_count+'  </h5>';
                                   var country_list='';
                                   var country=item.available_countries;
								                  if(country ) { 
                                   country_list='<h5><i class="fa fa-map-marker" aria-hidden="true"></i></h5>';
                                   country.forEach(function (item, index) {
                                    country_list+='<h5>'+item+' , </h5>';
                                  });
                                  }
                                  string+=country_list;

                                  string+='</div></div></div></a></div>'
                                   
                                   $("#product_list").append(string);
                                })
                                var img_path="<?php echo asset('/uploads/defaultImages/no-result.jpg')?>";   
                                if(productflag==false)
                                      $("#product_list").append('<img style="width:30%;height:auto" src="'+img_path+'"/>');

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

<script src="{{ asset('js/script.js')}}"></script>


@endsection