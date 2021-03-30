
	<nav class="nav__sidebar">
		<div class="options__checkbox" >
				<div class="brand__checkbox check__group clearfix" id='price-checkbox'>
					<h6>Nam</h6>
						@foreach($cateShare as $cate)
							@if($cate['parent_id']==1)
							 <a href="danh-muc/{{$cate['id']}}/{{$cate['slug_name']}}.html">{{$cate['name']}}</a><br>
							 @endif
						@endforeach
						
				</div>
				<div class="brand__checkbox check__group clearfix" id='brand-checkbox'>
					<h6>Nữ</h6>
						@foreach($cateShare as $cate)
							@if($cate['parent_id']==2)

							 <a href="danh-muc/{{$cate['id']}}/{{$cate['slug_name']}}.html">{{$cate['name']}}</a><br>
							 @endif
						@endforeach
				</div>
			</div>		
	</nav>
	<!--end-nav__sidebar-->
	