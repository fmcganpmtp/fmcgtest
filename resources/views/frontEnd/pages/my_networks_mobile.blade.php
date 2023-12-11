@extends('layouts.template_mobile')
@section('title', 'My Network')
@section('content')
<link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">


<sectiion class="seller-page no-bg   inner-page-C my-profile seller-pro edit-top nw-page-new">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
          
          
<div class="pr-bottom">


     <div class="card srch-seller serch-seller-sec3 networks-search ">
          <div class="sub-title">
        <h2>Expand Your Networks</h2>
      </div>
            <div class="row">
              <div class="col-lg-3 col-12">
                
        <div class="form-group">
                    <select id="search_by_category" class="list-menu" onchange="fnbtnsearchseller()">
                                        <option value="0">Select Category</option>
                                        @if($allcategorylists)
                                            @foreach($allcategorylists as $item)
                                             <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @endif
                    </select>
                  </div>
        
        </div>
        
        <div class="col-lg-3 col-12">
                
        <div class="form-group">
          <select type="text" multiple placeholder="Select Company Type" name="company_type[]" id='company_type' class="form-control" multiple="multiple">
           </select>    
           <input type="hidden" id="selected_company_type">
            </div>
        </div>
         <div class="col-lg-3 col-12">
         <div class="form-group">
              <select type="text" placeholder="Available Countries" name="available_countries[]" id='available_countries' class="form-control" multiple="multiple">
              </select>
              <input type="hidden" id="selected_country_id">
                  </div>
        
        </div>
        
        <div class="col-lg-3 col-12">
                <div class="form-group srch-frm7">
                  <input type="text" class="form-control" id="search_by_name" placeholder="Search by Name or Company"> 
                    <input type="hidden" id="start_from" value="0"> 
                   <button type="button" onclick="fnbtnsearchseller()"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
                
              </div>
        </div>
            <div class="row seller-result">
              <div class="col-lg-12 col-12">
                <div class="row" id="sellers_list"  ></div>
                <div class="default-btn load-btn" style="display: none;" id="loadmore" onclick="loadmore()">Load More...</div> 
              </div>
            </div>
          </div>      




     <div class="card m-cts1">
           <div class="sub-title">
        <h2>My Contacts</h2>
      </div>
           <div class="row">
          <div class="col-lg-3 col-12">
                
        <div class="form-group">
                    <select id="search_by_category1" class="list-menu" onchange="fnbtnsearchnetwork()">
                                        <option value="0">Select Category</option>
                                        @if($allcategorylists)
                                            @foreach($allcategorylists as $item)
                                             <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        @endif
                    </select>
                  </div>
        
        </div>   
        
        <div class="col-lg-3 col-12">
                
        <div class="form-group">
                    <select type="text" multiple placeholder="Select Company Type" name="company_type[]" id='company_type1' class="form-control" multiple="multiple">
           </select>    
           <input type="hidden" id="selected_company_type1">
            </div>
                  </div>
        
        </div>
        
         <div class="col-lg-3 col-12">
                
        <div class="form-group">
              <select type="text" placeholder="Available Countries" name="available_countries2[]" id='available_countries2' class="form-control" multiple="multiple">
              </select>
              <input type="hidden" id="selected_country_id2">
                  </div>
        
        </div>
        
        <div class="col-lg-3 col-12">
                <div class="form-group srch-frm7">
                  <input type="text" class="form-control" id="search_by_name1" placeholder="Search by Name or Company"> 
                    <input type="hidden" id="start_from1" value="0"> 
                   <button type="button" onclick="fnbtnsearchnetwork()"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
                
              </div>
        </div>
           <div class="row" id="network_list"></div>
            <div class="default-btn load-btn" style="display: none;width:16%" id="loadmore1" onclick="loadmore1()">Load More...</div>
        </div>


    
    
        </div>
      </div>
    </div>
  </div>
  
  

</sectiion>
<link rel="stylesheet" href="{{ asset('/css/select2.min.css')}}">

<script type="text/javascript">


var route1 = "{{route('company.types')}}";
   $fmcg('#company_type').select2({
     placeholder: 'Select Company Type',

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
      url: route1,
      dataType: 'json',
      delay: 250,
      processResults: function(data) {
        return {
          results: $fmcg.map(data, function(item) {
            return {
              html:"<span>"+item.company_type+"</span>",
              text: item.company_type,
              id: item.id
            }
          })
        };
      },
      cache: true,

    }
  }).on("change", function (e) {
     $fmcg("#selected_company_type").val($fmcg(this).val());
     fnbtnsearchseller();
  });
  
     $fmcg('#company_type1').select2({
     placeholder: 'Select Company Type',

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
      url: route1,
      dataType: 'json',
      delay: 250,
      processResults: function(data) {
        return {
          results: $fmcg.map(data, function(item) {
            return {
              html:"<span>"+item.company_type+"</span>",
              text: item.company_type,
              id: item.id
            }
          })
        };
      },
      cache: true,

    }
  }).on("change", function (e) {
     $fmcg("#selected_company_type1").val($fmcg(this).val());
     fnbtnsearchnetwork();
  });       

var route = "{{route('available.countries')}}";

  $fmcg('#available_countries').select2({
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
          results: $fmcg.map(data, function(item) {
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
     $fmcg("#selected_country_id").val($fmcg(this).val());
     fnbtnsearchseller();
  });
  
  
$fmcg('#available_countries2').select2({
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
          results: $fmcg.map(data, function(item) {
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
     $fmcg("#selected_country_id2").val($fmcg(this).val());
     fnbtnsearchnetwork();
  });



getnetworkList();
 $fmcg('#search_by_category,#search_by_category1').select2();
function loadmore(){
    //$fmcg(".loaderajax").show();
     fnloadsellers();
}
function loadmore1(){
     getnetworkList();
}
 $fmcg("#search_by_name").keydown(function (event) { 
     if (event.which == 13) { 
         event.preventDefault();
         fnbtnsearchseller();
     }
    });
 $fmcg("#search_by_name1").keydown(function (event) { 
     if (event.which == 13) { 
         event.preventDefault();
         fnbtnsearchnetwork();
     }
    });   
    
 function fnmovetoprofile(userid)
{
  window.location="{{route('ViewSeller.profile', ':id')}}".replace(':id', '')+userid;
}   

 function addtonetwork(userid)
   {
      // $fmcg(".loaderajax").show();
    $fmcg.ajax({
            url: "{{ url('profile_to_network') }}",
               type: "get",
               data:{ 
                   user_id: userid,
               },
               async:false,
               cache: false,
               dataType: 'json',
               success: function(data){ 
                   //$fmcg(".loaderajax").hide();
                 swal(data, "", "success");
                 $fmcg(".clsa"+userid).remove();
                 $fmcg(".clschat"+userid).show();
                 $fmcg('#start_from1').val(0);
                 $fmcg("#network_list").empty();
                 getnetworkList();
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                // $fmcg(".loaderajax").hide();
               swal(errorThrown, "", "error");
             }  
   
           })  ;
  }

function fnbtnsearchseller(){
    
     $fmcg('#start_from').val(0);
     $fmcg("#sellers_list").empty();
     fnloadsellers();
}

function fnbtnsearchnetwork(){
     $fmcg('#start_from1').val(0);
     $fmcg("#network_list").empty();
     getnetworkList();
}


function fnloadsellers(){

   // $fmcg(".loaderajax").show();
    $fmcg.ajax({
                          type:'POST',
                          url:'{{ route("getsellerslist_search") }}',
                          async:false,
                            cache: false,
                          data:{
                                '_token':'{{csrf_token()}}',
                                'seller_name':$fmcg('#search_by_name').val(),
                                'category_id':$fmcg('#search_by_category').val(),
                                'company_type':$fmcg('#selected_company_type').val(),
                                'selected_country_id':$fmcg('#selected_country_id').val(),
                                'start_from':$fmcg('#start_from').val(),
                                'per_page':9
                          },
                          success:function(response){ 
  
                            
                            let dataItems = JSON.parse(response);
                                    var initial=0;
                                    dataItems.sellers.map((item) => {
                                    initial++;


                     var string='<div class="col-lg-4 col-12"><div class=" slr-details nw-proC"><div class="row"><div class="col-lg-3"><div class="pro-logo-out"><div class="nw-prof-img '+item.class_verified+'">';
					 string+='<img src="'+item.img_path+'" onclick="fnmovetoprofile('+item.id+')" style="cursor: pointer;"></div>';
					 if(item.varification_status=='varified')
					  {
                      string+='<div class="active-tick"><i class="fa fa-check" aria-hidden="true"></i></div> ';							  
					  }
					  string+='</div></div><div class="col-lg-9 col-12"><ul><li onclick="fnmovetoprofile('+item.id+')" style="cursor: pointer;" class="nm"><b>'+item.company_name+'';
					  if(item.company_type !== '')
{
    string+='<span class="c-type"> ('+item.company_type+')</span>';
}	
					  string+='</b></li>';
					  string+='<li class="comp-nm">Name:'+item.name+'</li>';
					  if(item.country_name !== '')
{
					  string+='<li class="loca">Country:'+item.country_name+'</li>';
}
					  string+='</ul>';

                          if(item.network_exist==false)
                            string+='<a href="javascript:void(0)" onclick="addtonetwork('+item.id+')" class="cht-ico add-nt clsa'+item.id+'"><i class="fa fa-plus-square-o" aria-hidden="true"></i>Add to network</a>';
                          
                          else
                             string+='<a href="javascript:void(0)"  id="expandnetwork'+item.id+'" onclick="removefromnetwork('+item.id+')" class="cht-ico add-nt rmv"><i class="fa fa-trash-o" aria-hidden="true"></i>Remove from network</a>';
                           
                    
                     string+='<a href="javascript:void(0)" class="cht-ico" onclick="EnableChatRequest('+item.id+')" ><i class="fa fa-comments" aria-hidden="true"></i>Start chat</a>';
                    string+='</div></div></div></div></div>';
                    $fmcg("#sellers_list").append(string);


                                  })
                                 
                               // $fmcg(".loaderajax").hide();
                                  var skipcount=parseInt($fmcg("#start_from").val())+ initial ;
                                  if(dataItems.count!=skipcount)
                                        $fmcg("#loadmore").show();
                                  else
                                        $fmcg("#loadmore").hide();
  
                                 if ($fmcg("#sellers_list").find('div').length == 0)  
                                       $fmcg("#sellers_list").append("<p style='text-align:center;font-size:16px;margin-top:40px;margin-bottom:40px;'><b>No Profile's Found</b></p>"); 
  
                                  if(dataItems.sellers.length==0)
                                        $fmcg("#loadmore").hide();
  
                                  $fmcg("#start_from").val(skipcount);
  
                          },
                          error: function(XMLHttpRequest, textStatus, errorThrown) { 
                 //$fmcg(".loaderajax").hide();
               swal(errorThrown, "", "error");
             } 
                      });
  
}

function EnableChatRequest(seller_id){
          $fmcg(".message-input").css("display", "block");
          $fmcg("#frame").css("display", "block");
          $fmcg(".content").css("display", "block");
          $fmcg("#frame").css("width", "95%");
        
         
          $fmcg("#selected_id").val(seller_id);
          loadMessage();
          $fmcg("#frame").show();
          senter = seller_id;
          $fmcg("#txt_message").focus();      
           
        
}


function getnetworkList(){
   // $fmcg(".loaderajax").show();
  $fmcg.ajax({
            url: "{{ url('getnetwork_users_list') }}",
               type: "Post",
               async:false,
               cache: false,
               data:{
                                '_token':'{{csrf_token()}}',
                                'seller_name':$fmcg('#search_by_name1').val(),
                                'category_id':$fmcg('#search_by_category1').val(),
                                'company_type':$fmcg('#selected_company_type1').val(),
                                'start_from':$fmcg('#start_from1').val(),
                                'selected_country_id':$fmcg('#selected_country_id2').val(),
                                'per_page':9
                          },
               dataType: 'json',
               success: function(response){
                   
                  

                                    var initial=0;
                  response.mynetwork_list.map((item) => {
                                    initial++;
                      var string='<div class="col-lg-4 col-12" id="div_mynetwork'+item.id+'"><div class=" slr-details nw-proC " id ="'+item.id+'"><div class="row"><div class="col-lg-3"><div class="pro-logo-out"><div class="nw-prof-img '+item.class_verified+'">';
					  string+='<img src="'+item.img_path+'" onclick="fnmovetoprofile('+item.id+')" style="cursor: pointer;"></div>';
                      if(item.varification_status=='varified')
					       string+='<div class="active-tick"><i class="fa fa-check" aria-hidden="true"></i></div> ';							  
					  string+='</div></div><div class="col-lg-9"><ul><li onclick="fnmovetoprofile('+item.id+')" style="cursor: pointer;" class="nm">'+item.company_name+'';
					  if(item.company_type !== '')
{
    string+='<span class="c-type"> ('+item.company_type+')</span>';
}	
					  string+='</li><li  class="comp-nm">Name: <b>'+item.name+'</b> </li>';
					  if(item.country_name !== '') { 
					  string+='<li  class="loca">Country:'+item.country_name+'<br></li>';
					  }
					  string+=' </ul><a href="javascript:void(0)" onclick="removefromnetwork('+item.id+')" class="rmv"><i class="fa fa-trash-o" aria-hidden="true"></i>Remove from network</a><a href="javascript:void(0)" class="cht-ico" onclick="EnableChatRequest('+item.id+')" ><i class="fa fa-comments" aria-hidden="true"></i>Start chat</a></div></div></div></div> ';
                      $fmcg("#network_list").append(string);
                  });   
                    //$fmcg(".loaderajax").hide();
                   var skipcount=parseInt($fmcg("#start_from1").val())+ initial ;
                                  if(response.count!=skipcount)
                                        $fmcg("#loadmore1").show();
                                  else
                                        $fmcg("#loadmore1").hide();
  
                                 if ($fmcg("#network_list").find('div').length == 0)  
                                       $fmcg("#network_list").append("<p style='text-align:center;font-size:16px;margin-top:40px;margin-bottom:40px;'><b>No Contact's Found</b></p>"); 
  
                                  if(response.mynetwork_list.length==0)
                                        $fmcg("#loadmore1").hide();
  
                                  $fmcg("#start_from1").val(skipcount);               
                    
                               
             } ,

             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                // $fmcg(".loaderajax").hide();
               swal(errorThrown, "", "error");
             }  
   
           })  ;
}

  function removefromnetwork(userid)
   {
      // $fmcg(".loaderajax").show();
    $fmcg.ajax({
            url: "{{ url('revokeFrom_network') }}",
               type: "get",
               data:{ 
                   user_id: userid,
               },
               async:false,
               cache: false,
               dataType: 'json',
               success: function(data){
                   //$fmcg(".loaderajax").hide();
                 swal(data, "", "success");
                 $fmcg("#div_mynetwork"+userid).remove(); 
                 $fmcg("#expandnetwork"+userid).remove(); 
                 $fmcg("#home"+userid).remove();
             } ,
             error: function(XMLHttpRequest, textStatus, errorThrown) { 
                // $fmcg(".loaderajax").hide();
               swal(errorThrown, "", "error");
             }  
   
           })  ;
  }
</script>


  <style>
 
.add-nt{margin-right:4px;}
    .srch-seller .slr-details{ margin-top:0px;}
    .add-nt{ float:right;}
          
         .serch-seller-sec3 .nw-proC{ border-bottom:2px solid #edeaea;}
         .serch-seller-sec3 .nw-prof-img {
                overflow: hidden;
                border-radius: 50%;
                border: 2px solid #fff;
            }
          .serch-seller-sec3 .add-ntw{  padding:5px 10px; text-transform:uppercase; float:left; color:#fff; border-radius:4px; background:#0d6efd; border-bottom:2px solid #0561e9;}
          .add-ntw:hover{ background:#333; color:#FFFFFF;border-bottom:2px solid #333;}
          .chat-btn9{ color:#0d6efd; margin-left:10px; font-size:25px; margin-top:-4px; float:left;}
          .net-wrk-btn{ margin-top:17px; float:right;}
          .sr-listing8{ margin-bottom:10px;}
          
          .chat-btn9:hover{ color:#333;}
          
          .srch-frm7{ position:relative;}
          .srch-frm7 button{ background:none!important; padding:10px; position:absolute; right:10px; color:#000000; top:0; margin:0px 0px;}
          .seller-result{ margin-top:20px;}
          
          </style>


@endsection
