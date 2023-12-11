@extends('layouts.template')
@section('title', 'List Seller Products')
@section('content')


<style>
  table.dataTable thead .sorting_asc::after, table.dataTable thead .sorting::after  { position: relative !important;     top: 0px; }
</style>
<sectiion class="seller-page-new no-bg">
   
  <div class="pr-banner">
    <!--<img src="assets/images/pr-banner.jpg">-->
  </div>
  <div class="container">
    <div class="row">
         @if(Session::has('product_message')) <div class="alert alert-success">{{Session::get('product_message') }}</div> @endif  </div>
  </div>
  <div class="container">
    <div class="row">
        
      <div class="col-lg-12">
        <div class="pr-bottom">
		
		
		
		
		
    
          
<div class="card  tp-30 wow fadeInUp">
<div class="row">
              <div class="col-lg-12 col-12">
                <h3>Active Product list
</h3></div>
            <div class="row srch-top lst-seller">
              <div class="col-lg-3 col-12">
                <input type="search" id="search_key"  placeholder="Search...." class="form-control" >
              </div>
              <div class="col-lg-2 col-12">
                <div class="form-group">
                  <select type="text" id="category_id"  class="form-control" >
                                        <option value="">Filter By Category</option>
                                        @if($categories)
                                            @foreach($categories as $item)
                                                <?php $dash=''; ?>
                                                <option value="{{$item->id}}" >{{$item->name ?? ''}}</option>
                                                @if(count($item->subcategory))
                                                @include('admin/products/subCategory',['subcategories' => $item->subcategory])
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                </div>
              </div>
              <div class="col-lg-2 col-12">
                <div class="form-group">
                  <select id="stock" class="form-control">
                      <option value="">Filter By Stock</option>
                      <option value="instock" >Instock</option>
                      <option value="outstock" >Out of stock</option>
                      </select>
                </div>
              </div>
              
              <div class="col-lg-2 col-12">
              <button type="button"  id="btnsearch" class="btn btn-success btn-mrg"><i class="fa fa-search" aria-hidden="true"></i>Search</button>
              
              </div>
                <div class="col-lg-3 col-12">
                 <div class="btn-right">
              
                    <button type="button" onclick="fnbulkdelete('products',seller_products)" class="btn btn-outline-danger">Delete selected</button>
                    <a href="{{ route('add.seller.product')}}" class="btn btn-outline-primary">Add new product</a>
                    <!--  <a href="seller-Bulk-upload.php" class="btn btn-outline-info">Bulk upload</a> --></div>
              </div>
            </div>
            
          </div>
			
			
			
			
            <div class="tableC">
                    <table  id="datatable" class="table table-striped table-bordered datatable jtableNclass" data-page-length='20' cellspacing="0">
                <thead>
                  <tr>
                    <th></th>
                    <th> <div class="custom-control custom-checkbox">
                           <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Sl no </label>
                            </div></th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Image</th>
                    <th>Time and date</th>
                    <th> Actions</th>
                  </tr>
                </thead>
                
              </table>
            </div>
            
            
          
          </div>
		  
		  
		  
<div class="card wow fadeInUp">
              @if(Session::has('message')) <div class="alert alert-success">{{Session::get('message') }}</div> @endif
            <div class="slr-details">
              <div class="row ">
              <div class="col-lg-12 col-12">
                <h3>Bulk upload 
</h3></div>
              
              </div>
			  
			  
              <div class="row dwd-exel">
            	<div class="col-lg-6 col-12">
                
                	<div class="brd">
               <h4 class="h4-title">Download sample csv</h4>
                
                <ul>
                <li>Download the Sample CSV File.</li>
                <li>Fill the same with your product details.</li>
                <li>Provide the images as corresponding image links.</li>
                <li>Make sure the format is same as in the sample file.</li>
                <li>Upload the CSV.</li>
                <li>Make sure the products are updated in your profile with pending status.</li>
                <li>Wait for the Admin approval for displaying products in the platform.</li>
             </ul>
             
             <a href="{{ asset('/excel/').'/'.'sample.csv' }}" class="default-btn"> <i class="fa fa-file-excel-o" aria-hidden="true"></i>
Download</a>
                </div>
                </div>
                <div class="col-lg-6 col-12 c22">
                
                <div class="fupd">
                <h4 class="h4-title">Upload your products</h4>
                
                
                <form method="post" action="{{ route('import-exl') }}"  enctype="multipart/form-data" >
                  @csrf
                  @if (count($errors) > 0)
                
                      <div class="alert alert-danger alert-dismissible">
                         
                          <h6><i class="icon fa fa-ban"></i> Error!</h6>
                          @foreach($errors->all() as $error)
                          {{ $error }} <br>
                          @endforeach      
                      </div>
                    
                @endif
  
                @if (Session::has('success') && count($errors) == 0)
                    
                        <div class="alert alert-success alert-dismissible">
                           
                            <h6>{!! Session::get('success') !!}</h6>   
                        </div>
                      
                @endif
                <div class="upload-c">
                <div class="file-drop-area form-group">
                      <input type="file"  name="file" class="file-input form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required >
                      
                              <button class="default-btn"> <i class="fa fa-cloud-upload" aria-hidden="true"></i>

Upload</button>
                    </div>
                
                
                </div>
				</form>
				</div>
             
                </div>
            </div>
            </div>
          </div>
		  
			  <div class="card  tp-30 wow fadeInUp">
<div class="row">
              <div class="col-lg-12 col-12">
                <h3>Pending Product list
</h3></div>
            <div class="row srch-top">
              <div class="col-lg-4 col-12">
                <input type="search" id="search_key_pend"  placeholder="Search...." class="form-control" >
              </div>
              <div class="col-lg-2 col-12">
                 <div class="form-group">
                      <select type="text" id="category_id_pend"  class="form-control" >
                                        <option value="">Filter By Category</option>
                                        @if($categories)
                                            @foreach($categories as $item)
                                                <?php $dash='';
                                                $uplevel=$item->name;?>
                                                <option value="{{$item->name}}" >{{$item->name}}</option>
                                                @if(count($item->subcategory))
                                                @include('admin/products/subCategory_name',['subcategories' => $item->subcategory,'uplevel'=>$uplevel])
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                    </div>
             
              </div>
              <div class="col-lg-2 col-12">
                <div class="form-group">
                  <select id="stock_pend" class="form-control">
                      <option value="">Filter by Status</option>
                      <option value="instock" >Instock</option>
                      <option value="outstock" >Out of stock</option>
                      </select>
                </div>
              </div>
              
              <div class="col-lg-4 col-12">
              <button type="button"  id="btnsearch_pend" class="btn btn-success btn-mrg"><i class="fa fa-search" aria-hidden="true"></i>Search</button>

              <button type="button" onclick="fnbulkdelete('tempproducts',seller_products1)" class="btn btn-outline-danger">Delete selected</button>
              
              </div>
              
             
            </div>
            
          </div>
			
			
			
			
            <div class="tableC">
                    <table  id="datatable_pend" class="table table-striped table-bordered jtableNclass " data-page-length='20' cellspacing="0">
                <thead>
                  <tr>
                    <th></th>
                    <th><div class="custom-control custom-checkbox">
                           <input type="checkbox" class="custom-control-input" id="customCheck2">
                            <label class="custom-control-label" for="customCheck2"> Sl no</label>
                            </div></th>
                    <th>Category</th>
                    <th>Product name</th>
                    <th>Product Price</th>
                    <th>Image</th>
                    <th>Status</th>
					<th>Time and date</th>
					<th> Actions</th>
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
</sectiion>


      

@endsection
@section('footer_script')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{asset('/js/datatable.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('/admin1/js/sweetalert.js')}}"></script>
<script type="text/javascript">
 var seller_products=seller_products1=[];
 var $ = jQuery;
  (function($) {
    var id = '12';
    var editurl="{{route('edit.sellerProduct', ':id')}}";
    var deleteurl="{{route('delete.Sproduct', ':id')}}";
    var viewurl="{{route('view.Sproduct', ':id')}}";
    
     $("#customCheck1").click(function(){
      
       if($("#customCheck1").is(':checked'))
        {  
         seller_products=[]; 
         $(".clsallcheck").prop('checked',true);
         $(".clsallcheck").each(function() {
            seller_products.push(parseInt($(this).attr('id')));
          });
       }
      else
        {
          $(".clsallcheck").prop('checked',false);
           seller_products=[];
        }
      
    });
    
    $("#customCheck2").click(function(){
      
       if($("#customCheck2").is(':checked'))
        {  
         seller_products1=[]; 
         $(".clsallcheck2").prop('checked',true);
         $(".clsallcheck2").each(function() {
            seller_products1.push(parseInt($(this).attr('id')));
          });
       }
      else
        {
          $(".clsallcheck2").prop('checked',false);
           seller_products1=[];
        }
      
    });

    $('#btnsearch').click(function(){
    dataTable.draw();
    });
    $("#search_key").keydown(function (event) { 
     if (event.which == 13) { 
         event.preventDefault();
         dataTable.draw();
     }
    });
   var dataTable = $('#datatable').DataTable({
         "processing": true,
        "language": {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
         serverSide: true,
         'searching': false,
         "lengthChange": false,
         "order": [ 0,'desc'],
         'ajax': {
          'url':"{{ url('getSellerproductlistFrontEnd') }}",
          'data': function(data){
          _token="{{csrf_token()}}";
          data.search_key = $("#search_key").val();
          data.category_id =$("#category_id").val();  
          data.stock = $("#stock").val(); 
        },
      
    }, 
   
    "columnDefs":[
      {
       "targets":0, 
       "orderable": true,
       "visible":false
      },
      {
       "targets":6, 
       "orderable": false,
      
    },
      {
       "targets":1, 
       "orderable": false,
       "render": function(data,type,full,meta)
      {
          return '<div class="custom-control custom-checkbox"><input id="'+full.id+'" type="checkbox" class="custom-control-input clsallcheck"  onclick="fnPushId('+full.id+')"></div>' +(meta.row + meta.settings._iDisplayStart + 1);
      }
    },
    {
       "targets":8, 
       "orderable": false,
       "render": function(data,type,full,meta)
      {
        var str="'Do you really want to delete?'";
        editurl = editurl.replace(':id', '');
        deleteurl = deleteurl.replace(':id', '');
        viewurl = viewurl.replace(':id', '');
        return '<div class="icon-bx"> <a href="'+viewurl+full.id+'" class="view-ic"><i class="fa fa-eye" aria-hidden="true"></i></a> <a href="'+editurl+full.id+'" class="edit-ic"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="'+deleteurl+full.id+'" onclick="return confirm('+str+')" class="dlt-ic"><i class="fa fa-trash-o" aria-hidden="true"></i></a> </div>';     
      }
    }
  ],
         columns: [
          { data: 'id' },
          { data: 'id' },
          { data: 'cat_name' },
          { data: 'cat_name1' } ,  
          { data: 'name' },
          { data: 'product_price',className: "text-right" },
          { data: 'strimg' },
          { data: 'created_at' },
          { data: '' },
           
         ]
      });     
 })(jQuery);
</script>
<script type="text/javascript">
 
 var $ = jQuery;
  (function($) {


    var id = '12';
    var editurl1="{{route('edit.pending.sellerProduct', ':id')}}";
    var deleteurl1="{{route('delete.PendingSproduct', ':id')}}";
    var viewurl1="{{route('view.pending.Sproduct', ':id')}}";


    $('#btnsearch_pend').click(function(){
    datatable_pend.draw();
    });
    $("#search_key_pend").keydown(function (event) { 
     if (event.which == 13) { 
         event.preventDefault();
         datatable_pend.draw();
     }
    });
   var datatable_pend = $('#datatable_pend').DataTable({
          "processing": true,
        "language": {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '},
         serverSide: true,
         'searching': false,
         "lengthChange": false,
         "order": [ 0,'desc'],
         'ajax': {
          'url':"{{ url('getSPendingProductlist') }}",
          'data': function(data){
          _token="{{csrf_token()}}";
          data.search_key_pend = $("#search_key_pend").val();
          data.category_id_pend =$("#category_id_pend").val();  
          data.stock_pend = $("#stock_pend").val(); 
        },
      
    }, 
   
    "columnDefs":[
      {
       "targets":0, 
       "orderable": true,
       "visible":false
      },
      {
       "targets":1, 
       "orderable": false,
       "render": function(data,type,full,meta)
      {
          return '<div class="custom-control custom-checkbox"><input id="'+full.id+'" type="checkbox" class="custom-control-input clsallcheck2"  onclick="fnPush2Id('+full.id+')"></div>' +(meta.row + meta.settings._iDisplayStart + 1);
     
      }
    },
    {
       "targets":[5], 
       "orderable": false,
      
    },
	  {
       "targets":8, 
       "orderable": false,
       "render": function(data,type,full,meta)
      {
        var str="'Do you really want to delete?'";
        editurl1 = editurl1.replace(':id', '');
        deleteurl1 = deleteurl1.replace(':id', '');
        viewurl1 = viewurl1.replace(':id', '');
        return '<div class="icon-bx"> <a href="'+viewurl1+full.id+'" class="view-ic"><i class="fa fa-eye" aria-hidden="true"></i></a> <a href="'+editurl1+full.id+'" class="edit-ic"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="'+deleteurl1+full.id+'" onclick="return confirm('+str+')" class="dlt-ic"><i class="fa fa-trash-o" aria-hidden="true"></i></a> </div>';     
      }
    },
     
  ],
         columns: [
          { data: 'id' },
          { data: 'id' },
          { data: 'categories' } ,  
          { data: 'name' },
          { data: 'product_price',className: "text-right" },
          { data: 'strimg' },
          { data: 'status' },
          { data: 'created_at' },
		  { data: '' },
           
         ]
      });     
 })(jQuery);
 function fnbulkdelete(action_type,products){

   
  if(products.length>0)
    {
  swal({
    title:"Do you  want to Delete Product?",
    text: "",
    icon: "warning",
    buttons: true,
    dangerMode: true,
  })
  .then((willDelete) => {
    if (willDelete) {
         //$(".loaderajax").show();
          $.ajax({
              url: "{{ url('userproductbulkdelete') }}",
                  type: "post",
                  data:{ 
                      _token:'{{ csrf_token() }}',
                        seller_products: products,
                        action_type:action_type
                      },
                  async:true,
                  cache: false,
                  dataType: 'json',
                  success: function(data){
                        //$(".loaderajax").hide();
                        swal(data);
                        $("input:checkbox").prop('checked',"");
                        seller_products=[]; 
                        seller_products1=[]; 
                        location.reload();
                } ,
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    // $(".loaderajax").hide();
                  swal("Error: " ); 
                }  
      
              })  ;
      }
          
    }); 
  } 
  else
    swal("Please Select At Least One Item",'','error'); 
   


}
 function fnPushId(id){
  var exists = seller_products.includes(id)
  if (exists) 
    seller_products= seller_products.filter((c) => { return c !== id })
   else
    seller_products.push(id)
}
 function fnPush2Id(id){
  var exists = seller_products1.includes(id)
  if (exists) 
    seller_products1= seller_products1.filter((c) => { return c !== id })
   else
    seller_products1.push(id)
}
</script>
<style>
    .text-right {
    text-align: right;
}
</style>
@endsection