<?php

namespace App\Http\Controllers\frontend;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Country;
use App\Models\Order;
use App\Models\customerAddress;
use App\Models\OrderItem;
use App\Models\ShippingCharge;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\DiscountCoupon;

class CartController extends Controller
{
    public function addToCart(Request $request){

        $product = Product::with('product_images')->find($request->id);
        if( $product == null){
            return response()->json([
                'status' => true,
                'message' => 'Product not found'
            ]);
        }

        // nếu các phần tử trong cart > 0 thì thực hiện if
        if(Cart::count() > 0){
            // sản phẩm tồn tain trong cart
            // nếu kiểm tra product đã có trong giỏ hàng
            // thì trả về tin nhắn:  product already in you cart
            // nếu sản phẩm chưa tồn tại trong giỏ hàng, hãy thêm sản phẩm vào giỏ hàng

            $cartContent = Cart::content();
            $productAlreadyExist = false;

            // kiểm tra xem đã có sản phẩm nào trong cart trùng với sản phẩm sắp được thêm không
            foreach( $cartContent as $item){
                if($item -> id == $product->id){
                    $productAlreadyExist = true;
                }
            }

            // nếu sản phẩm này chưa trùng với sản phẩm nào trong giỏ hàng thì thêm vào
            if($productAlreadyExist == false){
                Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
                $status = true;
                $message = $product->title. " added in cart";
            } else{
                $status = false;
                $message = $product->title. " Already added in cart";
            }

        }else{

            // [productImage] : nếu sản phẩm có hình ảnh thì lấy hình ảnh đầu tiên của sản phẩm
            Cart::add($product->id, $product->title, 1, $product->price, ['productImage' => (!empty($product->product_images)) ? $product->product_images->first() : '']);
            $status = true;
            $message = $product->title.' added in cart';
        }

        return response()->json([
            'status' => $status,
            'message' =>  $message,
        ]);
    }
    public function cart(){
        $cartContent = Cart::content();
        // dd(Cart::content());
        return view('front-end.cart', compact('cartContent'));
    }

    public function updateCart(Request $request){
        $rowId = $request->rowId;
        $newQty = $request->qty;

        $itemInfo = Cart::get($rowId); // lấy rowId của sản phẩm sau đó từ rowId lấy ra id sản phẩm
        $product = Product::find($itemInfo->id);
        // check qty available stock
        if($product->track_qty == 'Yes'){

            if($product->qty >= $newQty){
                Cart::update($rowId, $newQty);
                $message = 'Cart updated successfully';
                $status = true;
                Session::flash('success', 'Cart updated successfully');


            }else{

                $message = 'Request quanty '.$newQty.' not available in stock';
                $status = false;
                Session::flash('error', $message);
            }
        }else{
            Cart::update($rowId, $newQty);
            $message = 'Cart updated successfully';
            $status = true;
            Session::flash('success', 'Cart updated successfully');


        }


        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }

    public function deleteCart(Request $request){

        $itemInfo = Cart::get($request->rowId);

        if( $itemInfo == null) {
            $errorMessage = 'Product not found in cart';
            Session::flash('error',  $errorMessage);
            return response()->json([
                'status' => false,
                'message' => $errorMessage,
            ]);

        }

        $successMessage = 'Product removed from cart successfully';
        Cart::remove($request->rowId);
        Session::flash('success',  $successMessage);
        return response()->json([
            'status' => true,
            'message' => $successMessage,
        ]);

    }

    public function checkout(Request $request){
        if(Auth::check() == false){
            session(['url.intended' => session('url.intended',  route('front.checkout'))]);

            return redirect()->route('account.login');
        }
       if(Cart::count() == 0){
            return redirect()->route('front.home');
       }
       session()->forget('url.intended'); // xóa url đã lưu đi

       $countries = Country::orderBy('name', 'ASC')->get();
       $customerAddress = customerAddress::where('user_id',(Auth::user()->id))->first();


       $discount = 0;
       $subTotal = Cart::subtotal(2,'.','');
       // apply discount coupon
       if(session()->has('code')){
           $code = session()->get('code');
           if($code->type == 'percent'){
               $discount = ($code->discount_amount/100)*$subTotal;
           }else{
               $discount = $code->discount_amount;
           }

        }
       // Calculate Shipping

       // nếu kết quả truy vấn trả về là true thì lấy ra cuontry_id của người dùng hiện tại đã có
       if(!empty($customerAddress)){
            $userCountry = $customerAddress->country_id;

            $shippingInfor = ShippingCharge::where('country_id', $userCountry)->first();
            $totalQty = 0;
            foreach(Cart::content() as $item){
                $totalQty += $item->qty;

            }
            $totalShippingCharge = 0;
            $grandTotal = 0 ;

            // truy vấn thành công đến thông tin ShippingCharge thì if trả về true
            if ($shippingInfor) {
                $totalShippingCharge = $totalQty * $shippingInfor->amount;

            } else {   // nếu shippingInfor rỗng thì giá tiền sẽ được đặt theo giá đã quy định cho rest_of_world
                $shippingInfor = ShippingCharge::where('country_id', 'rest_of_world')->first();
                $totalShippingCharge = $totalQty*$shippingInfor->amount;

            }

            $grandTotal = ($subTotal-$discount) + $totalShippingCharge;

       }else{ // nếu người dùng hiện tại chưa có country_id thì mặc định giá tiền ship = 0
            $totalShippingCharge = 0;
            $grandTotal = ($subTotal-$discount);


       }



       return view('front-end.checkout', compact('countries', 'customerAddress', 'totalShippingCharge', 'grandTotal', 'discount'));
    }

    public function processCheckout(Request $request){
        // 1 - Apply validation
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|min:5',
            'last_name' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'country' => 'required',
            'address' => 'required|min:30',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Please fill in the missing fields',
                'errors'=> $validator->errors(),
            ]);
        }else{

            // 2 - lưu thông tin vào bảng customer_address

            $user = Auth::user();
            // tìm kiếm  xem có bản ghi nào có user_id == user_id của người đăng nhập hiện tại không,
            // nếu có bản ghi trùng thì cập nhật lại giá trị của bản ghi, nếu không trùng thì sẽ tạo mới bản ghi
            // với id đăng nhập hiện tại
            customerAddress::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'address' => $request->address,
                    'apartment' => $request->apartment,
                    'country_id' => $request->country,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip' => $request->zip,

                ]
            );

            // 3 - lưu thông tin vào bảng order
            if($request->payment_method == 'cod'){
                $subTotal = Cart::subtotal(2,'.','');
                $shipping = 0;
                $discount = 0;
                $grandTotal = $subTotal + $shipping;
                $totalQty= 0;
                $code = null;

                if(session()->has('code')){
                    $code = session()->get('code');
                    if($code->type == 'percent'){
                        $discount = ($code->discount_amount/100)*$subTotal;
                    }else{
                        $discount = $code->discount_amount;
                    }
                }

                $shippingInfor = ShippingCharge::where('country_id', $request->country)->first();
                foreach(Cart::content() as $item){
                    $totalQty += $item->qty;
                }
                if(!empty($shippingInfor)){
                    $shipping = $totalQty*$shippingInfor->amount;
                    $grandTotal =  ($subTotal-$discount) + $shipping;

                }else{
                    $shippingInfor = ShippingCharge::where('country_id', 'rest_of_world')->first();
                    $shipping = $totalQty*$shippingInfor->amount;
                    $grandTotal =  ($subTotal-$discount) + $shipping;
                }



                $order = new Order();
                $order->user_id = $user->id;
                $order->subtotal = $subTotal;
                $order->shipping = $shipping;
                if(!empty($code)){
                    $order->coupon_code = $code->code;
                    $order->coupon_code_id = $code->id;
                }else{
                    $order->coupon_code = null;
                    $order->coupon_code_id = null;
                }

                $order->discount = $discount;
                $order->grand_total = $grandTotal;


                $order->payment_status = 'not paid';
                $order->status = 'pending';
                $order->first_name = $request->first_name;
                $order->last_name = $request->last_name;
                $order->email = $request->email;
                $order->mobile = $request->mobile;
                $order->country_id = $request->country;
                $order->address = $request->address;
                $order->apartment = $request->apartment;
                $order->city = $request->city;
                $order->state = $request->state;
                $order->zip = $request->zip;
                $order->order_note = $request->order_notes;
                $order->save();

            // 4 - lưu thông tin vào bảng item

                foreach(Cart::content() as $item){
                    $orderItem = new OrderItem();
                    $orderItem->order_id =  $order->id;
                    $orderItem->product_id = $item->id;
                    $orderItem->name = $item->name;
                    $orderItem->qty = $item->qty;
                    $orderItem->price = $item->price;
                    $orderItem->total = $item->qty*$item->price;
                    $orderItem->save();

                    // update of stock
                    $productData = Product::find($item->id);
                    if($productData->track_qty == 'Yes'){
                        $currentQty = $productData->qty;
                        $updateQty = $currentQty-$item->qty;
                        $productData->qty = $updateQty;
                        $productData->save();
                    }



                }
                orderMail($order->id, 'customer');
                Session::flash('success', 'You have placed your order successfully. We will process and send the goods as soon as possible');
                return response()->json([
                    'status' => true,
                    'order_id'=> $order->id,
                    'message' => 'Order saved successfully'

                ]);

            }


        }


    }
    public function thankYou($id){
        $id = $id;
        Cart::destroy();
        session()->forget('code');
        return view('front-end.thanks', compact('id'));
    }

    public function getOrderSummery(Request $request){
        $subTotal = Cart::subtotal(2, '.', '');

        $discount = 0;
        $discountString = '';
        // apply discount coupon
        if(session()->has('code')){
            $code = session()->get('code');
            if($code->type == 'percent'){
                $discount = ($code->discount_amount/100)*$subTotal;
            }else{
                $discount = $code->discount_amount;
            }
            $discountString = '
            <div id="discount-response" class=" mt-4">
                 <strong>'.session()->get('code')->code.'</strong>
                 <a id="remove-discount" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
             </div>';
         }


        // nếu request trả về country_id lớn hơn 0 thì if được kích hoạt
        if($request->country_id > 0){
            $shippingInfor = ShippingCharge::where('country_id', $request->country_id)->first();
            $totalQty = 0;
            foreach(Cart::content() as $item){
                 $totalQty += $item->qty;

            }

            // nếu thông tin về country_id trả về khác rỗng thì if được kích hoạt, ngược lại else được kích hoạt
            if(!empty($shippingInfor)){
                $shippingCharge = $totalQty*$shippingInfor->amount;
                $grandTotal =  ($subTotal-$discount) + $shippingCharge;

                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal, 2),
                    'discount' => $discount,
                    'discountString' => $discountString,
                    'shippingCharge' => number_format($shippingCharge, 2)
                ]);
            // nếu không có thông tin về giá của country_id hiện tại thì mức giá rest_of_world sẽ được kích hoạt
            }else{
                $shippingInfor = ShippingCharge::where('country_id', 'rest_of_world')->first();
                $shippingCharge = $totalQty*$shippingInfor->amount;
                $grandTotal =  ($subTotal-$discount) + $shippingCharge;

                return response()->json([
                    'status' => true,
                    'grandTotal' => number_format($grandTotal, 2),
                    'discount' => $discount,
                    'discountString' => $discountString,
                    'shippingCharge' => number_format($shippingCharge,2)
                ]);
            }

        // nếu chưa có country nào được chọn thì phí ship = 0
        }else{

            return response()->json([
                'status' => true,
                'grandTotal' => number_format($subTotal-$discount, 2),
                'discount' => $discount,
                'discountString' => $discountString,
                'shippingCharge' => 0

            ]);
        }

    }

    public function applyDiscount(Request $request){

        $code = DiscountCoupon::where('code', $request->code)->first();



        // kiểm tra xem biến code có rỗng hay không
        if(empty($code)){
            return response()->json([
                'status' => false,
                'message' => 'Invalid discount coupon',

            ]);
        }

        $now = Carbon::now();

        if($code->start_at != ''){
            $startDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->start_at); // tạo 1 đối tượng carbon để có thể thao tác với ngày tháng vd: so sánh thời gian
            if($now->lt( $startDate)){  // Sử dụng phương thức lt (less than) để kiểm tra nếu thời gian hiện tại nhỏ hơn startDate thì trả về false
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid discount coupon start date',

                ]);
            }
        }

        if($code->expires_at != ''){
            $endDate = Carbon::createFromFormat('Y-m-d H:i:s', $code->expires_at); // tạo 1 đối tượng carbon để có thể thao tác với ngày tháng vd: so sánh thời gian
            if($now->gt( $endDate)){    //Sử dụng phương thức gt (greater than) để kiểm tra nếu thời gian hiện tại lớn hơn endDate thì trả về false
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid discount coupon end date',

                ]);
            }
        }

        $count = 0;
        // $discount_coupon = DiscountCoupon::find($code->id);
        if( $code->max_uses_user > 0){

            // kiểm tra xem có bao nhiêu bản ghi trong bảng orders  mà id_user khớp với id của người dùng hiện tại và id_coupon khớp với id hiện tại
            $couponUsedUser = Order::where(['user_id' => Auth::user()->id, 'coupon_code_id' => $code->id])->count();
            if($couponUsedUser >= $code->max_uses_user){

                return response()->json([
                    'status' => false,
                    'message' => 'the user out of coupons'
                ]);
            }else{
                $code->max_uses_user -= 1;
                $code->save();

            }
        }

        if($code->max_uses > 0){
            $couponUsed = Order::where('coupon_code_id', $code->id)->count(); // đếm số lần xuất hiện coupon_code_id trong bảng Orders

            if( $couponUsed >= $code->max_uses){
                return response()->json([
                    'status' => false,
                    'message' => 'Coupons end of use'
                ]);
            }else{
                $code->max_uses -= 1;
                $code->save();
            }
        }

        // kiểm tra xem giá tiền sản phẩm có lớn hơn số tiền tối thiểu để áp dụng mã giảm giá hay không
        $subTotal = Cart::subtotal(2,'.','');
        if($code->min_amount > 0){
            if($subTotal < $code->min_amount){
                return response()->json([
                    'status' => false,
                    'message' => 'Your min amount must be $'.$code->min_amount.'.',
                ]);
            }
        }



        Session::put('code', $code);

        return $this->getOrderSummery($request);
    }

    public function removeCoupon(Request $request){
        $code = session()->get('code'); // Lấy mã giảm giá từ session

        if ($code) {
            // Tăng max_uses lên 1
            $discountCoupon = DiscountCoupon::where('code', $code->code)->first();

            if ($discountCoupon) {
                $discountCoupon->max_uses += 1;
                $discountCoupon->max_uses_user += 1;
                $discountCoupon->save();
            }
        }

        session()->forget('code');
        return $this->getOrderSummery($request);
    }

}
