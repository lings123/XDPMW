<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',['as'=>'trang-chu','uses'=>'PageController@getIndexPage']);
Route:: get('gioi-thieu','PageController@getGioiThieu');
Route::get('shop','PageController@getall');
Route::get('danh-muc/{id}/{url}',['as'=>'chuyen-muc','uses'=>'PageController@getCategory']);

Route::get('san-pham/{id}/{url}',['as'=>'san-pham','uses'=>'PageController@getDetailProduct']);

Route::get('gio-hang',['as'=>'giohang','uses'=>'PageController@getShowCart']);

Route::get('thanh-toan',['as'=>'thanhtoan','uses'=>'PageController@getShowCheckout']);

Route::post('thanh-toan',['as'=>'thanhtoan','uses'=>'PageController@postCheckout']);

Route::get('dang-ky',['as'=>'dangky','uses'=>'PageController@getDangKy']);

Route::post('dang-ky',['as'=>'dangky','uses'=>'PageController@postDangKy']);

Route::get('dang-nhap',['as'=>'get.login','uses'=>'PageController@getLogin']);

Route::post('dang-nhap',['as'=>'post.login','uses'=>'PageController@postLogin']);

Route::get('dang-xuat','PageController@getDangXuat');

Route::get('tim-kiem',['as'=>'search','uses'=>'PageController@getSearch']);

Route::group(['prefix'=>'ajax'],function (){
	Route::post('add-to-cart','AjaxController@postAjaxAddtoCart');

	Route::post("remove/item",'AjaxController@postAjaxRemoveProduct');

	Route::post('xuly-quantity','AjaxController@postAjaxXulyQuantity');
});

Route::group(['prefix'=>'user'], function (){
	Route::get('profile',['as'=>'user.profile', 'uses'=>'PageController@getUserProfile']);

	Route::post('profile',['as'=>'user.profile', 'uses'=>'PageController@postEditProfile']);
	
	Route::get('password',['as'=>'get.password', 'uses'=>'PageController@getChangePassword']);

	Route::post('password',['as'=>'post.password', 'uses'=>'PageController@postChangePassword']);

	
});



Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
	Route::get('/',['as'=>'admin-index','uses'=>'CategoryController@getIndexAdmin']);

	Route::group(['prefix'=>'danh-muc'],function(){

		Route::get("them",['as'=>'themdanhmuc','uses'=>'CategoryController@getAddCate']);

		Route::post("them",['as'=>'themdanhmuc','uses'=>'CategoryController@postAddCate']);

		Route::get("sua/{id}",['as'=>'suadanhmuc','uses'=>'CategoryController@getEditCate']);

		Route::post("sua/{id}",['as'=>'suadanhmuc','uses'=>'CategoryController@postEditCate']);

		Route::get("danh-sach",['as'=>'listdanhmuc','uses'=>'CategoryController@getListCate']);

		Route::get('xoa/{id}',"CategoryController@getDelCate");

	});

	Route::group(['prefix'=>'san-pham'],function () {
		
		Route::get("them",['as'=>'themsanpham','uses'=>'ProductController@getAddProduct']);

		Route::post("them",['as'=>'themsanpham','uses'=>'ProductController@postAddProduct']);

		Route::get("size/them/{id}",['as'=>'themsize','uses'=>'ProductController@getAddSize']);

		Route::post("size/them/{id}",['as'=>'themsize','uses'=>'ProductController@postAddSize']);

		Route::get("danh-sach","ProductController@getListProduct");

		Route::get("sua/{id}","ProductController@getEditProduct");

		Route::post("sua/{id}","ProductController@postEditProduct");

		Route::get("hinh/sua/{id}","ProductController@getEditImage");

		Route::post("hinh/sua/{id}","ProductController@postEditImage");

	});

	Route::group(['prefix'=>'thuong-hieu'],function (){
		Route::get('danh-sach','BrandController@getListBrand');

		Route::get('them','BrandController@getAddBrand');

		Route::post('them','BrandController@postAddBrand');

		Route::get('sua/{id}','BrandController@geteditBrand');

		Route::post('sua/{id}','BrandController@postEditBrand');

		Route::get('xoa/{id}','BrandController@getDelBrand');

	});

	Route::group(['prefix'=>'user'],function (){
		Route::get('them','UserController@getAddUser');

		Route::post('them','UserController@postAddUser');

		Route::get('danh-sach','UserController@getListUser');

		Route::get('sua/{id}','UserController@getEditUser');

		Route::post('sua/{id}','UserController@postEditUser');

		Route::get('xoa/{id}','UserController@getDelUser');


	});

	Route::group(['prefix'=>'size'],function (){
		Route::get('them','SizeController@getAddSizes');

		Route::post('them','SizeController@postAddSizes');

		Route::get('danh-sach','SizeController@getListSizes');

		Route::get('sua/{id}','SizeController@getEditSizes');

		Route::post('sua/{id}','SizeController@postEditSizes');

		Route::get('xoa/{id}','SizeController@getDelSizes');

	});
	

	Route::group(['prefix'=>'don-hang'],function (){

		Route::get('danh-sach','BillController@getListBill');

		Route::get('xoa/{id}','BillController@getDelBill');

		Route::get('chi-tiet/{id}',['as'=>'admin.detail.bill', 'uses'=>'BillController@getDetailBill']);

		Route::get('chi-tiet/xoa/{id}','BillController@getDelDetailBill');
	});

	

	
	Route::post('ajax/view-size',"ProductController@postAjaxViewSize");

	Route::post('ajax/del-image',"ProductController@postAjaxDelImage");

	Route::post('ajax/edit-quantity','ProductController@postAjaxEditQuantity');

	
});
	Route::get('admin/dang-nhap','Admin\UserController@getAdminLogin');

	Route::post('admin/dang-nhap','Admin\UserController@postAdminLogin');

	Route::get('admin/logout','Admin\UserController@getAdminLogout');
