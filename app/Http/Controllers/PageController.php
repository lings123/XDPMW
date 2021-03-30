<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\ProductProperties;
use App\Category;
use App\ImageProduct;
use App\Size;

use \Cart;
use Session;
use App\Customer;
use App\Bills;
use App\DetailBill;
use App\Brand;
use App\User;

use App\Http\Requests\CustomerRequest;
use App\Http\Requests\UserRequest;
use App\Notifications\checkoutNoti;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{

    public function __construct()
    {   
        //truyyền viewshare . loai san pham tới kahcs mọi trang trong page
        $cateShare = Category::get()->toArray();
       // $slider=DB::table('sider_image')->get()->toArray();
        view()->share(['cateShare'=>$cateShare]);
    }
    public function getall(){
          $cate = Category::all();
        $products = Product::select('*')->orderBy('id','ASC')->paginate(10);
        return view('page.shop',compact('products','cate'));
    }
    public function getIndexPage()
    {
        $new_product = Product::where('new',1)->select('id','name','slug_name','image_product','unit_price','promotion_price','new')->limit(5)->orderBy('id','desc')->get();
        
        $sale_product = Product::where('promotion_price','>',0)->select('id','name','slug_name','image_product','unit_price','promotion_price','new')->limit(5)->orderBy('id','desc')->get();
    
        return view('page.index',compact('new_product','sale_product'));
    }
    public function getGioiThieu(){
        return view('page.gioithieu');
    }
   
    public function getCategory($id,Request $request)
    {   
        $cate = Category::find($id);
        if(!empty($cate)){
            // lay cac cate con cua cate_hientai
            $cates_child = Category::where('parent_id',$id)->get();
            // kiem tra ton tai cate cha khong
            $cate_parent = Category::find($cate->parent_id);
            $brands = Brand::all();
            $sizes = Size::all();
            $cate_id = $id;
            if(count($cates_child) > 0 )
            {       
                $children_id = null;
                foreach($cates_child as $cate_c)
                {
                    $children_id[] = $cate_c->id;
                }
                //nếu là cate cha thi wherein id cate con, va cha
                $children =  implode(',',$children_id);
                $products = Product::whereIn('cate_id',$children)->select(DB::raw('*'))->orderBy('name','ASC')->paginate(10);
               
            }else{
                $products = Product::where('cate_id',$id)->select(DB::raw('*'))->orderBy('name','ASC')->paginate(10);
            }
            if(!empty($cate_parent)){
                return view('page.category',compact('products','cate','cate_id','brands','sizes','cate_parent'));
            }
            return view('page.category',compact('products','cate','cate_id','brands','sizes'));
        } else {
            return redirect(route('trang-chu'));
        }
    }
    public function getSearch(Request $req){
        
        $products = Product::where('name','like','%'.$req->txtKeyword.'%')->orderBy('id','desc')->paginate(10);
        $cate = Category::all();
        //$cate_id = $cate['id'];
        return view('page.search',compact('products','cate'));
        }
    //Lây chi tiết sản phẩm
    public function getDetailProduct($id)
    {
        $product        = Product::find($id);
        $cate_id        = $product->cate_id;
        $cates          = Category::find($cate_id);
        //lay cate cha
        $cates_parent   = Category::find($cates->parent_id);
        
        $diff_products = Product::where('cate_id',$cate_id)->where('id',"<>",$id)->limit(4)->get();
        $image_products = ImageProduct::where('product_id', $id)->get();

        return view('page.detail',compact('product','image_products','cate_id','cates','cates_parent','diff_products'));
        
    }

  
  //get lấy dữ liệu
    public function getShowCart(){
        return view('page.cart');
    }

    public function getShowCheckout(){
        return view('page.checkout');
    }
//Lưu dữ liệu
    public function postCheckout(CustomerRequest $request){
        
        //Kiêm tra xem số lượng mỗi sản phẩm có còn trong kho hàng nữa không
        $flag = true;
        $list_soil_out = "";
        foreach(Cart::content() as $row)
        {
            $rowId = $row->rowId;
            $product_per = ProductProperties::where('product_id',$row->id)->where('size_id',$row->options->size_id)->select('quantity')->get()->first();
            $quantity_repository = $product_per->quantity;
            //Nếu số lượng trong kho bằng 0 thì xóa sản phẩm đó ra khỏi cart
            if($quantity_repository == 0){
                $size = Size::find($row->options->size_id);
                $size_name = $size->name;
                $list_soil_out .= " ".$row->name." size: ".$size_name." đã hết hàng<br/>";
                $flag = false;
                Cart::remove($rowId);
            }      
            //nếu số lượng trong cart lớn hơn kho     
            else if($row->qty > $quantity_repository)
            {
                $size = Size::find($row->options->size_id);
                $size_name = $size->name;
                $list_soil_out .= " ".$row->name." size: ".$size_name." còn ".$quantity_repository." sản phẩm<br/>";
                $flag = false;
                //update lại số lượng sản phẩm trong cart bằng số lượng trong kho.
                Cart::update($rowId,['qty'=>$quantity_repository]);
            }
        }
        //nếu có những sản phẩm đã hết, hoặc số lượng ít hơn lựa chọn thì thông báo cho người dùng
        if($flag == false){
            return redirect('thanh-toan')->with('loi',"Bạn vui lòng kiểm tra lại giỏ hàng: <br/>".$list_soil_out);
        }
        else{
            $customer = new Customer;
            $customer->email      = $request->txtEmail;
            $customer->first_name = $request->txtFirstName;
            $customer->last_name  = $request->txtLastName;
            $customer->gender     = $request->txtGender;
            $customer->address    = $request->txtAddress;
            $customer->phone      = $request->txtPhone;
            if(Auth::check()) 
            {
                 $customer->user_id = Auth::user()->id;
             } 
            if($customer->save())
            {   //lưu thonong tin dơn hàng
                $customer_id       = Customer::max('id');   
                $bill = new Bills;
                $bill->customer_id = $customer_id;

                $total_price = Cart::subtotal(0,'','');

                //$coupon_value = 0; //set coupon defult
               

                //$total_price -= $total_price * $coupon_value;

                $bill->total_price = $total_price;
                if($bill->save())
                {   //lưu thông tin chi tiết đơn hàng
                    $bill_id  = Bills::max('id');
                    foreach(Cart::content() as $cart)
                    {
                        $detail_bill             = new DetailBill;
                        $detail_bill->bill_id    = $bill_id;
                        $detail_bill->product_id = $cart->id;
                        $detail_bill->size_id    = $cart->options->size_id;
                        $detail_bill->quantity   = $cart->qty;
                        $detail_bill->price = $cart->price;
                        $price      = $cart->subtotal(0,'','');
    
                        $detail_bill->save();

                        $product_p = ProductProperties::where('product_id',$cart->id)->where('size_id',$cart->options->size_id)->select('quantity')->get()->first();
                        $quantity = $product_p->quantity;
                        $quantity_remain = $quantity - $cart->qty;

                        //cập nhật lại số lượng hàng trong kho
                        $quantity = DB::table('product_properties')->where('product_id',$cart->id)->where('size_id',$cart->options->size_id)->update(['quantity'=>$quantity_remain]);
                        
                    }
                    //dispatch(new SendBillInfoMail($customer, Cart::content(), $total_price, $coupon_value));
                    // send notifications
                    $users = User::where('admin', 1)->get();
                    
                    $when = Carbon::now()->addSeconds(10);

                    $bill = Bills::find($bill_id);
                    
                    // send notification
                    

                    Cart::destroy();
                    //session()->forget('coupon');
                    return redirect('thanh-toan')->with('success',"Thanh toán thành công. Nhấp vào <a href='". route('trang-chu')."' style='color:#333' >đây</a> để về trang chủ");
                }else{
                    return redirect('thanh-toan')->with('loi',"Không thể lưu lại thông tin đơn hàng");
                }
            }else{
                 return redirect('thanh-toan')->with('loi',"Không thể lưu lại thông tin khách hàng");
            }
        }   
    }
   
    public function getDangKy()
    {
        if(Auth::check()){
            return redirect('/');
        }
        return view('page.register');
    }
    public function postDangKy(UserRequest $request)
    {
        $this->validate($request,[
            'txtEmail' => 'unique:users,email'
        ],[
            "txtEmail.unique" => "Email của bạn đã tồn tại"
        ]);
         if($request->txtPass != $request->txtConfirmPass){
            return redirect('dang-ky')->with('loi','Mật khẩu không trùng khớp');
        }else{
            $user = new User;
            $user->first_name = $request->txtFirstName;
            $user->last_name  = $request->txtLastName;
            $user->email      = $request->txtEmail;
            $user->password   = bcrypt($request->txtPass);
            $token = hash_hmac('sha256', '123', config('app.key'));
            $user->remember_token=$token;
            $user->save();

            return redirect('dang-ky')->with('thongbao',"Đăng kí thành công.Nhấp vào <a href='". route('post.login')."' style='color:#333' >đây</a> để về trang chủ");
        }
    }
        
   
    public function getDangXuat(){
        if(Auth::check()){
            Auth::logout();    
        }
        return redirect('/');
    }

    public function getUserProfile(){
        return view('page.user_profile');
    }
    public function postEditProfile(CustomerRequest $request){
        $id = Auth::user()->id;
        $this->validate($request,[
            'txtEmail' => 'unique:users,email,'.$id
        ],[
            "txtEmail.unique" => "Email của bạn đã tồn tại"
        ]);
        $user = User::find($id);
        $user->email      = $request->txtEmail;
        $user->first_name = $request->txtFirstName;
        $user->last_name  = $request->txtLastName;
        $user->address    = $request->txtAddress;
        $user->phone      = $request->txtPhone;
        $user->save();

        return redirect(route('user.profile'))->with('success','Thành công');
    }

    public function getChangePassword(){

        return view('page.password');

    }
    public function PostChangePassword(Request $request){
       $this->validate($request, [
            "txtOldPassword" => "required",
            "txtNewPassword" => "required|min:6",
            "txtConfirmPass" => "required"
       ],[
            "txtOldPassword.required" => "Bạn phải nhập mật khẩu cũ",
            "txtNewPassword.required" => "Bạn phải nhập mật khẩu mới",
            "txtNewPassword.min" => "Mật khẩu mới phải có ít nhất 6 kí tự",
            "txtConfirmPass.required" => "Bạn phải nhập lại mật khẩu mới",
       ]);
       if(Hash::check($request->txtOldPassword, Auth::user()->password)){
           if($request->txtNewPassword == $request->txtConfirmPass){
               $user = User::find(Auth::user()->id);
               $user->password = bcrypt($request->txtNewPassword);
               $user->save();
               return redirect(route("get.password"))->with('success','Đổi mật khẩu thành công');
           }else{
               return redirect(route("get.password"))->with('error','Mật khẩu confirm phải trùng khớp');
           }
       }else{
           return redirect(route("get.password"))->with('error','Mật khẩu cũ không chính xác');
       }
    }
    public function getLogin(){
        if(Auth::check()){
            return redirect(route('trang-chu'));
        }else{
            return view('page.login');
        }
    }
    public function postLogin(Request $request){
        $this->validate($request, [
            "txtEmail" => "required|email",
            "txtPassword" => "required"
        ],[
            "txtEmail.required" => "Bạn phải nhập email",
            
            "txtPassword.required" => "Bạn phải nhập mật khẩu"
        ]);
        $credentials = [
            'email' => $request->txtEmail,
            'password' => $request->txtPassword,
        ];
        if(Auth::attempt($credentials)){
            return redirect()->back();
        }else{
            return redirect(route('get.login'))->with('error','Sai email hoặc mật khẩu! Vui lòng kiểm tra lại');
        }
    }
   
}
