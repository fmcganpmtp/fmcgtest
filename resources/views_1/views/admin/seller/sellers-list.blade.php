@extends('admin.master')
@section('title', 'Sellers List')
@section('breadcrumb') Sellers List @endsection
@section('content')

  <div class="body flex-grow-1 px-3">
    <div class="container-lg">
      <div class="card-out mb-4 inner-form">
      @if(Session::has('message')) <div class="alert alert-success">{{Session::get('message') }}</div> @endif
        <h2>Sellers List</h2>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-12 col-12">
              <div class="card ">
                <div class="card-header">
                 <form action="{{route('admin.sellerslist')}}" method="GET">
                  
     
                <div class="row">
                            <div class="col-lg-4 col-12">
                    
                    <div class="search-area wth-btn width_100">
                    
                     <div class="form-group">
                     <input type="search" name="search_key" id="search_key"  placeholder="Search...." class="form-control">
                   </div>
                    
                    </div>
                     </div>
                    
                    <div class="col-lg-2 col-12">
                    
                    
                    
                        	<div class="form-group">
                   
                      
                          <select name="status" id="status" class="form-control">
                                  <option value="">All</option>
                                  <option value="Blocked">Blocked</option>
                                  <option value="Active">Active</option>
                                  <option value="Pending">Pending</option>
                                  <option value="Rejected">Rejected</option>
                          </select>
                    </div>
                        </div>
                        <div class="col-lg-6 col-12">
                        <button type="button" class="bl-btn pd01 " id="btnsearch"><i class="fa fa-search" aria-hidden="true"></i> Search</button> 

                        <div class="flt-right">
                            <button type="submit" name="filter" value="Excel" class="bl-btn flt-right1 pd01"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel export</button> 
                            <a href="{{route('sellerprofile.create')}}" class="bl-btn flt-right1  left-10 pd01"> <i class="fa fa-pencil" aria-hidden="true"></i> Create</a>
                        </div></div>
                    </div>
                </div>
              </form>
                <div class="card-body">
                  <div class="tableC ad-rl-list">
                  <table id="datatable" class="table  table-bordered" data-page-length='20' cellspacing="0" width="100%">
                    <thead>
                        <tr>
                          <th></th>
                          <th>Sl no</th>
                          <th>Name</th>
                          <th>Company name</th>
                          <th> Email</th>
                          <th>Phone</th>
                          <th>Created at</th>
                          <th>Address</th>
                          <th> Country</th>
                          <th>Subscription End</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                            
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
  </div>

 <div class="modal fade" id="Mymodal" tabindex="-1" aria-labelledby="MymodalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="MymodalLabel">Assign Package</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="fnclosepopup1()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
     <div class="form-group">
          <input type="hidden" id="hdnuser_id">
          <label>Package Name:</label>
          <br>
          <select class="form-control" id="package_list">
            <option></option>
          </select>
          <div id="package_details"></div> 
           <div id="package_sub_item">
          <label>Choose No of Profiles: </label>
          <select class="form-control" id="subitem" required="">
            <option></option>
          </select>
          </div> 
     </div>
          <button  type="submit" onclick="adminassignpackage()" class="bl-btn mar-10">SUBMIT</button>
        
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
  </div>
</div> 

<script src="{{asset('/admin1/js/datatable.js')}}"></script>
<script src="{{asset('/admin1/js/sweetalert.js')}}"></script>
<script>
var $ = jQuery;
  (function($) {
  $(document).ready( function () {

    $("#package_sub_item").hide();
    $("#package_list").change(function(){

      $.ajax({
         url: "{{ url('getpackageselected_details') }}",
            type: "post",
            data:{ _token:'{{ csrf_token() }}',id:$(this).val() },
            async:false,
            cache: false,
            dataType: 'json',
            success: function(data){
                    var string="";
                    $("#package_sub_item").hide();
                    $("#package_details").empty();
                    if(data.details!=null)
                    { 
                      string+="<br>Basic Price: $"+data.details.package_basic_price +" <br> Offer Price: $"+ data.details.package_offer_price +" <br>Description: "+data.details.package_description+" <br>Validity: "+data.details.package_validity +" <br>Type: "+data.details.subscription_type+"<br><br>";
                      $("#package_details").empty().append(string);
                   
                      var extendpack="";
                      var discount=0;
                                     
                      data.PackageAccount.map((item) => {
                            $("#package_sub_item").show();
                            discount=parseInt(((item.cost_per_account - item.per_account_offer_price)/item.cost_per_account)*100);
                            extendpack+='<option value='+item.id+'>'+item.no_of_accounts+' Profiles, '+discount+' % off $'+item.per_account_offer_price+'/ Account</option>';
                                       });
                      $("#subitem").empty().append(extendpack);}
          } ,
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
            swal(errorThrown, "", "failure");
          }  

        })  ;

    })
   
    var id = '12';
	  var viewurl="{{route('admin.sellerview', ':id')}}";
    var editurl="{{route('admin.selleredit', ':id')}}";
    var deleteurl="{{route('admin.sellerview', ':id')}}";
    var sellerproductcreateurl="{{route('admin.sellerproduct_create', ':id')}}";
   
    var Blocked="'Blocked'";
    var Active="'Active'";
    var str='';
    $('#btnsearch').click(function(){
    dataTable.draw();
    });
    $("#search_key").keydown(function (event) { 
     if (event.which == 13) { 
         event.preventDefault();
         dataTable.draw();
     }
    });
    var dataTable=$('#datatable').DataTable({
         processing: false,
         serverSide: true,
        'searching': false,
        "lengthChange": false,
        "order": [ 0,'desc'],
        'ajax': {
        'url':"{{ url('getsellerslist') }}",
        'data': function(data){
          _token="{{csrf_token()}}";
          data.search_key = $("#search_key").val();
          data.status= $("#status").val();
       },
      
    },"columnDefs":[
    {
       "targets":0, 
       "orderable": true,
       "visible":false
      },
      {
       "targets":9, 
       "orderable": false,
       },
      {
       "targets":1, 
       "orderable": false,
       "render": function(data,type,full,meta)
      {
        return meta.row + meta.settings._iDisplayStart + 1;
      }
    },
      {
       "targets":10, 
       "orderable": false,
       "render": function(data,type,full,meta)
      {
        viewurl = viewurl.replace(':id', '');
        editurl = editurl.replace(':id', '');
        deleteurl = deleteurl.replace(':id', '');
        sellerproductcreateurl = sellerproductcreateurl.replace(':id', '');
        
         str='<div class="icon-bx"><button type="button" title="Assign Package" onclick="fnassignpackage('+full.id+')" style="border: 0 none;"><i class="fa fa-usd" aria-hidden="true"></i></button> <a href="'+sellerproductcreateurl+full.id+'" title="Add Seller Products"><i class="fa fa-plus-square-o" aria-hidden="true"></i></a> <a href="'+editurl+full.id+'"><i class="icon  cil-pencil"></i></a><a href="JavaScript:void(0);" onclick="deleteconfirm('+full.id+')"><i class="icon cil-trash"></i></a><a href="'+viewurl+full.id+'"><i class="fa fa-eye" aria-hidden="true"></i></a>';
        if(full.status!='Blocked')
        str+='<button type="button" title="Block This User" onclick="fnstatusupdator('+full.id+','+Blocked+')" style="border: 0 none;"><i class="fa fa-ban" aria-hidden="true"></i></button>';
        if(full.status!='Active')
          str+='<button type="button" title="Active This User" onclick="fnstatusupdator('+full.id+','+Active+')" style="border: 0 none;"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></button>';
         str+='</div>';
         
        return str;
      }
    }
  ],
         columns: [
          { data: 'id' },
          { data: 'id' },
          { data: 'name' },
          { data: 'company_name' } ,  
          { data: 'email' } ,
          { data: 'phone' } ,
          { data: 'created_at' },  
          { data: 'address' },  
          { data: 'country_name' },
          { data: 'subscription' }, 
         ]
      });

  
     
  });
})(jQuery);


function adminassignpackage(){
  var package_list=$("#package_list").val();
  if(package_list!=""){

       swal({
        title: "Are you Sure, you want to assign Package to this profile?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
           url: "{{ url('adminassignpackagetoadmin') }}",
            type: "post",
            data:{ 
                _token:'{{ csrf_token() }}',
                  hdnuser_id: $("#hdnuser_id").val(),
                  package_id: $("#package_list").val(),
                  subitem: $("#subitem").val()
            },
            async:true,
            cache: false,
            dataType: 'json',
            success: function(data){
              swal(data, "", "success");
              $('#Mymodal').modal('hide');
          } ,
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
            swal("Error", "", "failure");
          }  

        })  ;
        } else {
          
        }
      });  

  }
 }

function fnassignpackage(user_id){

  var activeplan=0;

   $.ajax({
         url: "{{ url('fetchUserhaveactiveplan') }}",
            type: "get",
            data:{ 
                _token:'{{ csrf_token() }}',
                 user_id:user_id
                },
            async:false,
            cache: false,
            dataType: 'json',
            success: function(data){
                activeplan=data;
            } ,
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
           
          }  

        })  ;

    if(activeplan!=0)
     {

       swal({
        title: "You Have Active Plan.Do you want to change Active plan to In Active!",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          fninsertorderdetails(user_id);
        } else {
          
        }
      }); 
      
    }
    else
      fninsertorderdetails(user_id);

    
 }
function fninsertorderdetails(user_id){

  $("#package_sub_item").hide();
          $.ajax({
              url: "{{ url('getpackagenamelist') }}",
                 type: "get",
                 data:{ 
                     _token:'{{ csrf_token() }}',
                      user_type:'Seller'
                     },
                 async:false,
                 cache: false,
                 dataType: 'json',
                 success: function(data){
     
                  var option="<option></option>";
                   data.map((item) => {
                    option+='<option value='+item.id+'>'+item.name+'</option>';
                   });
                   $("#package_list").empty().append(option);
               } ,
               error: function(XMLHttpRequest, textStatus, errorThrown) { 
                 swal(errorThrown, "", "failure");
               }  
     
             })  ;
     
        $("#subitem").empty();
        $("#package_details").empty();
        $('#Mymodal').modal('show');
        $("#hdnuser_id").val(user_id);

}

function fnclosepopup1(){
    $("#Mymodal").modal('hide');
}
function fnstatusupdator(id,type){
  var msg="";
  if(type=="Blocked")
    msg="Are you Sure you want to Block this profile?";
  else
    msg="Are you Sure you want to Activate this profile?";

    swal({
        title: msg,
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
         url: "{{ url('sellersstatusupdates') }}",
            type: "post",
            data:{ 
                _token:'{{ csrf_token() }}',
                  id: id,
                  status: type,
            },
            async:true,
            cache: false,
            dataType: 'json',
            success: function(data){
              swal(data, "", "success");
              location.reload();
          } ,
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
            swal(errorThrown, "", "failure");
          }  

        })  ;
        } else {
          
        }
      });  

  
}


function deleteconfirm(data){
  var deleteurl="{{route('delete.selleruser', ':id')}}".replace(':id', '')+data;

  swal({
    title:"Do you really want to delete? " ,
    text: "",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
       $.ajax({
         url: deleteurl,
            type: "get",
            async:true,
            cache: false,
            dataType: 'json',
            success: function(data){
              if(data==true)
              {   swal('Deleted Successfully');
                    location.reload();
              }
              else
                  swal('Deletion Failed');
              
          } ,
          error: function(XMLHttpRequest, textStatus, errorThrown) { 
            alert("Error: " + errorThrown); 
          }  

        })  ;
    } 
    else {
          
        }
    });  

}
</script>

@endsection