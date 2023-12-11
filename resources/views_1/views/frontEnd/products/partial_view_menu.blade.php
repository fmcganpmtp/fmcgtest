

              	 @foreach($menu_items as $items)
				
            	 @if(count($items->subcategory)>0)
            	 		<li><a href="{{route('Product.Listing',['search_key'=>$items->slug])}}">{{$items->name}}</a></li>
              			@include('frontEnd/products/partial_view_menu',['menu_items' => $items->subcategory])

				@else
              	 <li><a href="{{route('Product.Listing',['search_key'=>$items->slug])}}">{{$items->name}}</a></li>
              	@endif
              	@endforeach
                	
              	

  
