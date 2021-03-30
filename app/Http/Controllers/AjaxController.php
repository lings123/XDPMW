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
use App\Coupon;
use Session;
use App\Customer;
use App\Bills;
use App\DetailBill;
use App\Brand;
use App\Http\Requests\CheckoutRequests;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
   public function postAjaxAddtoCart(Request $request)
    {
         $product_id = $request->product_id;
        $size_id = $request->size_id;
        $qty = $request->qty;
        $product = Product::find($product_id);
       
        if($product->promotion_price > 0)
        {
            $price = $product->promotion_price;
        }else{
            $price = $product->unit_price;
        }
        $product_per = ProductProperties::where('product_id',$product_id)->where('size_id',$size_id)->select('quantity')->get()->first();
        $quantity = $product_per->quantity;
        $valid = array('success' => false, 'messages' => array());
      
        // nếu số lượng sản phẩm trong cart và selectbox lớn hơn trong database
        $count = Cart::count();
        $quantity_on_cart = 0;
        if($count > 0)
        {
           
            foreach(Cart::content() as $row)
            {
                if(($product_id == $row->id) && ($size_id == $row->options->size_id))
                {
                    $quantity_on_cart = $row->qty;
                }
            }
            $quantity -= $quantity_on_cart ;
        }

        if($qty > $quantity){
            $valid['success'] = false;
            $valid['messages'] = "Sản phẩm đã hết size hoặc vui lòng chọn số lượng nhỏ hơn";
            echo json_encode(
                array(
                    'valid' => $valid
                )
            );
        }else{
            Cart::add(['id' => $product_id, 'name' => $product->name, 'qty' => $qty, 'price' => $price, 'weight' => $price, 'options' => ['size_id' => $size_id, 'image' => $product->image_product, 'slug_name' => $product->slug_name]]);

            $image_product = $product->image_product;
            $product_name  = $product->name;
            $size          = Size::find($size_id);
            $product_size  = $size->name;
            $total_price   = Cart::subtotal(0,"","");
            //nếu đơn hàng hơn 200000 thì free ship
            // if($total_price > 2000000)
            // {
            //     $ship_price = 0;
            // }else{
            //     $ship_price = 50000;
            // }
            $ship_price = 0;
            //Tổng tiền bằng tổng trừ ship 
            $total       = $total_price + $ship_price;
            $total       =  number_format($total);
            $total_price = number_format($total_price);
            $ship_price  = number_format($ship_price);
            
            $valid['success'] = true;
            $valid['messages'] = "Thành công";
            $cart_count  = Cart::count();
            $price = number_format($price); // format_price
            //response
            echo json_encode(
                array( 
                    "product_id"       => "$product_id",
                    "product_name"     => "$product_name",
                    "image_product"    => "$image_product",
                    "product_size"     => "$product_size",
                    "total"            => "$total",
                    "qty"              => "$qty",
                    "price"            => "$price",
                    "ship_price"       => "$ship_price",
                    "total_price"      => "$total_price",
                    "cart_count"       => "$cart_count",
                    'quantity_on_cart' => "$quantity_on_cart",
                    'valid'            => $valid
                )
            );
        }
    }
    

  
  public function postAjaxRemoveProduct(Request $request){
        $rowId = $request->rowId;
        foreach(Cart::content() as $cart)
        {
            if($cart->rowId == $rowId)
            {
                Cart::remove($rowId);
                echo "Success";
            }else{
                echo "false";
            }
        } 
    }
    
    public function postAjaxXulyQuantity(Request $request)
    {
        $rowId = $request->rowId;
        $quantity = $request->quantity;

        foreach(Cart::content() as $cart)
        {
            if($cart->rowId == $rowId)
            {
                $product_id = $cart->id;
                $size_id = $cart->options->size_id;
            }
        }

        // //lấy số lượng sản phẩm có trong giỏ hàng
        $product_per = ProductProperties::where('product_id',$product_id)->where('size_id',$size_id)->select('quantity')->get()->first();
        $p_quantity = $product_per->quantity;
        
        $valid = array('success' => false, 'messages' => array());

         if($quantity > $p_quantity)
         {
            $valid['success'] = false;
            $valid['messages'] = "Số lượng nhập vào quá lớn đề nghị bạn nhập lại";
            echo json_encode(
            array(
                "rowId" => "$rowId",
                "quantity" => "$quantity",
                "valid" => $valid
                )
            );
        }else{
          
            Cart::update($rowId, $quantity);
             foreach(Cart::content() as $row)
            {
                if($row->rowId == $rowId)
                {
                    $row_total = $row->subtotal(0,".",",");
                }
            }

            $valid['success'] = true;
            $valid['messages'] = "Thành công";
            $total_price = Cart::subtotal(0,".",",");
            
            echo json_encode(
                array(
                "rowId" => "$rowId",
                "row_total" => "$row_total",
                'total_price' => "$total_price",
                'valid' => $valid
                )
            );
        }
    }
 
}
