

            <ul>
				@foreach($menu_items as $items)
				
            	 @if(count($items->subcategory)>0)
            	 
              			<li><a href="javascript:void(0)">{{$items->name}}</a>
              			@include('frontEnd/products/partial_mobile_view',['menu_items' => $items->subcategory])
              	</li>
              	
              	@else
              	<li> <a href="{{route('Product.Listing',['search_key'=>$items->slug])}}">{{$items->name}}</a> </li>
              	@endif

              	@endforeach
            </ul>
  
