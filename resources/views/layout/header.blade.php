	<div class='top-bar row'>
		<div class="col-md-6 top-bar-left">
			<ul class="nav">
			  <li class="nav-item">
			    <a class="nav-link active" href="#"></a>
			  </li>
			</ul>
		</div>
		<div class="col-md-6 top-bar-right">
		
			<ul class="nav justify-content-end">
			  	<li class="nav-item cart-link">
			    	<a class="nav-link cart-select"  href="gio-hang"><span class="glyphicon glyphicon-shopping-cart"></span> Giỏ hàng <span class="cart__count">@if(Cart::count() > 0) ({{Cart::count()}}) @endif</span></a>
			    	
			    	<!-- end-cart-body-->
					</li>
				@if(Auth::check())
					<li class="nav-item login-link">
						<a class="nav-link show-user-nav" href="javascript:void(0)">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</a>
							<div class="dropdown-nav popup__user-nav">
									<ul>
											<li>
													<a href="{{ route('user.profile') }}">Thông tin cá nhân</a>
											</li>
											<li>
													<a href="{{ route('get.password') }}">Đổi mật khẩu</a>
											</li>
											
											<li>
													<a href="dang-xuat">Đăng xuất</a>
											</li>
									</ul>
							</div>
					</li>		  	
			 	@else
			 	<li class="nav-item">
			    	<a class="nav-link small-hidden" href="dang-nhap">Đăng nhập</a>
			 	</li>
			  	<li class="nav-item">
			    	<a class="nav-link small-hidden" href="dang-ky">Đăng kí</a>
			 	</li>
			 	@endif
			</ul>
		</div>
	</div>
	<!-- top-bar -->
	<div class="row clearfix" id="header-logo">
		<div class='col-12 col-sm-12 col-md-6 col-lg-6 ' id='header-logo-center'>
			<p class='p-logo'><a href="">SHOES OF NHOM 2</a></p><hr>
		</div>

<div class='col-12 col-sm-12 col-md-6 col-lg-6 '>
<div class="search-box">
						
			        	<form role="search" method="get" id="searchform" action="{{route('search')}}">
							<input type="text" name="txtKeyword" placeholder="Nhập từ khóa cần tìm kiếm" class="search-input">
							<span class='icon-search'><i class="fa fa-search" aria-hidden="true"></i></span>
						</form>
						<div class="search-result">
						</div>
					</div>
			    	
			 	
		
	</div>
</div>
	

	<!-- Header-Logo -->
		
	<div class='col-12 col-sm-12 '>
		<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" style="height: 500px" src="uploaded/slider/banner1.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" style="height: 500px"  src="uploaded/slider/banner2.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100"  style="height: 500px"  src="uploaded/slider/banner3.jpg" alt="Third slide">
    </div>
  </div>
  <a  style="height: 500px"  class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a  style="height: 500px"  class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  

</div>
<div class='col-12 col-sm-12 '>
		<nav class="navbar navbar-default navbar-expand-lg navbar-dark bg-dark" >

			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" >
			    <span class="navbar-toggler-icon" ></span>
			  </button>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			    <ul class="navbar-nav mr-auto menu-list">
			      <li class="nav-item active">
			        <a class="nav-link" href="{{ route('trang-chu') }}">Home <span class="sr-only">(current)</span>
			       </a>
			       
			      </li>
			      <li class="nav-item " >
				   <a class="nav-link" href="{{ url('shop') }}">Shop
			         </a>  
			     </li> 
			    @foreach($cateShare as $cate)
			      		@if($cate['parent_id'] == 0)

			      			<?php $cate_child = App\Category::where('parent_id',$cate['id'])->get();
			      			?>
			      			@if(count($cate_child) > 0)
					      		<li class="nav-item dropdown">
							        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							          {{$cate['name']}}
							        </a>
							        <ul class="sub-menu" aria-labelledby="navbarDropdown">
							          	@foreach($cate_child as $cate_c)
							          		  <a class="dropdown-item" href="danh-muc/{{$cate_c->id}}/{{$cate_c->slug_name}}.html">{{$cate_c->name}}</a>
							          	@endforeach
							        </ul>
							    </li>
							 @else
							 	<li class="nav-item">
						         	<a class="nav-link" href="danh-muc/{{$cate->id}}/{{$cate->slug_name}}.html}}">{{$cate-name}}</a>
						      	</li>
							 @endif
			      		@endif
			      	@endforeach
			      	
					 
			        
			      
			       <li class="nav-item " >
				   <a class="nav-link" href="{{ url('gioi-thieu') }}">Giới thiệu
			         </a>  
			     </li>  
			    </ul>
			  </div>
		</nav>
		<!--end-nav-->
	</div>