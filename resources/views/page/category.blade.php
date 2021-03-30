@extends('layout.master')
@section('content')
<div id='wrapper'>
	<div class="row">
		<div class="col-12 col-sm-2 col-md-2 col-lg-2 nav-left small--text-center">
		<hr class="hr--border-top small-hidden"></hr>
			
			@include('layout.sider_nav')
		</div>
		<div class="col-12 col-sm-12 col-md-10 col-lg-10 block-main-content">
			<div class='main-content'>
			<hr class="hr--border-top small-hidden"></hr>
			<nav class="breadcrumb-nav small--text-center" aria-label="You are here">
			  	<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
			    	<a href="{{ route('trang-chu') }}" itemprop="url" title="Back to the homepage">
			      	<span>Home</span>
			    </a>
				@if(!empty($cate_parent))
			    	<span class="breadcrumb-nav__separator" aria-hidden="true">›</span>
			  	</span>
				  	{{ $cate_parent['name'] }}
				@endif
			</nav>
			
			<!--end-grid-->
			<div class='block_wrap row' id="pd">
				
					<div class="row filter-tag">
					</div>
					<div class="page_info"> 	
						<p class="p__total_item">@if(count($products) > 0) Hiển thị: <span>{{ $products->firstItem() }}</span> - <span>{{ $products->lastItem() }}</span> trong @endif <span>{{ $products->total()}}</span> sản phẩm</p>
					</div>
					
					@if(count($products) > 0 )
					<div class="row clearfix" style="width: 100%;" id="list_product"> 
						@foreach($products as $product) 
					  	<div class="product-item">
							<div class="thumbnail">
								@if($product->promotion_price > 0 )
								<span class="badge badge--sale" style="color: #FFFF">Sale</span>
								@endif
								@if($product->new == 1 )
						   		<span class="badge badge--new" style="background-color: yellow;color: #000000">New</span>
						   		@endif
						      	<a href="san-pham/{{$product->id}}/{{$product->slug_name}}.html"><img src="uploaded/product/{{$product->image_product}}" alt="..."></a>
						     	<div class="product-caption text-left">
						        	<p class='product-title'><a href="san-pham/{{$product->id}}/{{$product->slug_name}}.html">{{$product->name}}</a></p>
						        	<p class='product-price'>
					        		@if($product->promotion_price > 0 )
							        	<span class="product__price-on-sale">{{number_format($product->promotion_price)}}</span>
										<s class="product__price--compare">{{number_format($product->unit_price)}}</s> vnđ
									@else
										<span> {{number_format($product->unit_price)}}</span> vnđ
									@endif
						        	</p>
						        <p class='product-btn__p' ><a href="san-pham/{{$product->id}}/{{$product->slug_name}}.html" class="product-btn__a" role="button"><span class="glyphicon glyphicon-search"></span> Chi tiết</a></p>
						      	</div>
						    </div>
					  	</div>

			  			@endforeach
			  		</div>	
			  		<div class="block_center block_paginate">
			  				{{$products->links()}}
			  			</div>
			  	
				  	@else
				  		<p class="text-center messages">Không có sản phẩm phù hợp!</p>
				  	@endif
			  	</div>
			  			
			  
			
			<!--block_wrap-->
		</div>
		<!--end-main-content-->
	</div>
	<!--block-main-content-->
	</div>
	<!--end-row-->
</div>
<!--end-wrapper-->
@endsection
@section('title')
	{{$cate['name']}}
@endsection