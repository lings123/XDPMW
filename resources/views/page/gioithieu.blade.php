@extends('layout.master')
@section('content')
<div id='wrapper'>
	<div class="row">
		<div class="col-12 col-sm-2 col-md-2 col-lg-2 nav-left small--text-center">
			<hr class="hr--border-top small-hidden"></hr>
			
			<!--end-nav__sidebar-->
		</div>

		<div class="col-12 col-sm-12 col-md-10 col-lg-10 ">
			<div class='main-content'>
				<hr class="hr--border-top small-hidden"></hr>
				<div class=''>
					<nav class="breadcrumb-nav small--text-center" aria-label="You are here">
						<a href="index.html" itemprop="url" title="Back to the homepage">
							<span itemprop="title">Home</span>
						</a>
						<span class="breadcrumb-nav__separator" aria-hidden="true">›</span>
						<a href="gioi-thieu">Giới thiệu</a>

						<h4></h4>
					</nav>
				</div>

				<div class='block_wrap row profile_block'>
					<div class='col-8'>
						<p class='section__title'>Thông Tin các thành viên</p>
						<h6>Gia Lệ</h6>
						<h6>Quang Nhựt</h6>
						<h6>Hoàng Thư</h6>
						<h6>Chí Hoàng</h6>
						<h6>Đình Tài</h6>
				</div>
				<!--end-block_wrap-->
			</div>
			<!--end-main-content-->
		</div>
	</div>
    <!--end-row-->
</div>
	
@endsection	
@section('title')
	Thông tin cá nhân
@endsection