<?php

namespace App\Http\Controllers\frontend;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(){

        return view('front-end.account.login');
    }
    public function register(){
        return view('front-end.account.register');
    }

    public function processRegister(Request $request){
        $validator = Validator::make( $request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        if($validator->passes()){
            // tạo và lưu thông tin người dùng
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            // tạo avatar từ tên của người dùng
            $avatarPath = 'avatar-' . $user->id .'.png';
            Avatar::create($user->name)->save(public_path('img-avatar/avatar-user/' .$avatarPath));
            $user->avatar = $avatarPath;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Registered successfully'
            ]);


        }else{
            return response()->json([
                'status' => false,
                'errors'=> $validator->errors(),
            ]);
        }
    }
    public function authenticate( Request $request){
        $validator = Validator::make( $request->all(), [

            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        if($validator->passes()){

            if(Auth::guard('web')->attempt(['email'=>$request->email, 'password'=>$request->password], $request->get('remember'))){
                Log::info('AuthController Authenticate:', [
                    'guard' => 'web',
                    'authenticated' => Auth::guard('web')->check()
                ]);

                $request->session()->regenerate(); // tái tạo lại 1 ID session cho phiên

                if(session()->has('url.intended')){
                   return redirect(session()->get('url.intended'));
                }
                return redirect()->route('account.profile');

            }else{

                return redirect()->route('account.login')->withInput($request->only('email'))->with('error', 'Email or password not correct!');
            }
        }else{
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }


    public function profile(){
        $user = User::where('id', Auth::user()->id)->first();
        return view('front-end.account.profile', compact('user'));
    }

    public function updateProfile(Request $request){

        $userId = Auth::user()->id;
        $user = User::find($userId);
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$userId.',id',
            'phone' => 'required'
        ]);

        if( $validator->passes()){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => "updated profile for you successfully"
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function logout(Request $request){
        Log::info('User Logout Initiated');
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Log::info('User Logout Completed');

        return redirect()->route('account.login')->with('success', 'You successfullt logout ');
    }

    public function orders(){

        $user = auth::user();
        $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
        return view('front-end.account.order', compact('orders'));
    }

    public function orders_detail(Request $request, $id){
        $orders = Order::find($id);
        $order_items = OrderItem::where('order_id', $orders->id)->get();
        $products = [];

        foreach($order_items as $order_item){
            $product = Product::with('product_images')->where('id', $order_item->product_id)->first();
            if($product){
                $products[$order_item->product_id] = $product;
            }
        }

        $data = [
            'orders' => $orders,
            'order_items' =>  $order_items,
            'products' => $products,
        ];
        return view('front-end.account.order_detail', $data);

    }

    public function wishlish(Request $request){

        $wishlists = Wishlist::where('user_id', Auth::user()->id)->with('product')->get();

        return view('front-end.account.wishlist', compact('wishlists'));

    }

    public function removeProductWishlist(Request $request){
        $wishlistProduct = Wishlist::where('user_id', Auth::user()->id)->where('product_id', $request->id)->first();

        if($wishlistProduct == null){
            session()->flash('error', 'Product not found!');
            return response()->json([
                'status' => false,
            ]);
        }else{
            $wishlistProduct->delete();

            session()->flash('success', 'Product deleted successfully');
            return response()->json([
                'status' => true,
            ]);
        }
    }

    public function showChangePassword(){
        return view('front-end.account.change-password');
    }

    public function processChangePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ]);

        if($validator->passes()){
            $user = User::select('id', 'password')->where('id', Auth::user()->id)->first();
            if(Hash::check($request->old_password, $user->password)){
                User::where('id', $user->id)->update([
                    'password' => Hash::make($request->new_password)
                ]);
                session()->flash('success', 'You have change password successfully');
                return response()->json([
                    'status' => true
                ]);

            }else{
                session()->flash('error', 'You old password is incorrect, pleass try again.');
                return response()->json([
                    'status' => true
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);

        }
    }

    public function forgotPassword(){
        return view('front-end.account.forgot-password');
    }

    public function processForgotPassword(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email',
        ]);

        if($validator->passes()){
           $token = Str::random(10);

           DB::table('password_reset_tokens')->where('email', $request->email)->delete();
           DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()

           ]);


           // send email
           $user = User::where('email', $request->email)->first();
           $mailData = [
                'token' => $token,
                'user' => $user,
                'mailSubject' => 'You have requested to change password'
           ];
           Mail::to($request->email)->send( new ResetPassword($mailData));
           return redirect()->route('front.forgotPassword')->with('success','please check you inbox reset you password code');
        }else{
            return redirect()->route('front.forgotPassword')->withInput()->withErrors($validator->errors());
        }
    }
    public function resetPassword($token){
        $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first();

        if($tokenExist == null){
             return redirect()->route('front.forgotPassword')->with('error', 'Invalid request');
        }
        return view('front-end.account.reset-password', [
            'token' => $token
        ]);
    }

    public function processResetPassword( Request $request){
        $token  = $request->token;

        $tokenObj = DB::table('password_reset_tokens')->where('token', $token)->first();

        if($tokenObj == null){
             return redirect()->route('front.forgotPassword')->with('error', 'Invalid request');
        }else{
            $user = User::where('email', $tokenObj->email)->first();
            $validator = Validator::make($request->all(), [
                'new_password' => 'required|min:8',
                'confirm_password' => 'required|same:new_password',
            ]);

            if($validator->fails()){
                return redirect()->route('front.resetPassword', $token)->withInput()->withErrors($validator->errors());

            }else{
                User::where('id', $user->id)->update([
                    'password' => Hash::make($request->new_password)
                ]);
                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
                return redirect()->route('account.login')->with('success', 'You have successfully updated your password');
            }
        }
    }


}
