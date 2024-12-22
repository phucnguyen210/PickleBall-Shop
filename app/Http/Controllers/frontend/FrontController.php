<?php

namespace App\Http\Controllers\frontend;
use App\Http\Controllers\Controller;
use App\Mail\ContactEmail;
use App\Models\Page;
use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function index(){
        $featuredProduct = Product::orderBy('title', 'ASC')->with('product_images')->where('is_featured', 'Yes')->where('status', 1)->take(8)->get()->
        map(function($product) {
            $product->title = Str::limit($product->title, 40);
            return $product;
        });
        $latestProduct = Product::where('status', 1)->with('product_images')->orderBy('id', 'DESC')->take(8)->get()
        ->map(function($product) {
            $product->title = Str::limit($product->title, 40);
            return $product;
        });
        // dd($latestProduct);
        return view('front-end.home', compact('featuredProduct', 'latestProduct'));
    }

    public function addToWishlist(Request $request) {
        if(Auth::check() == false){

            session(['url.intended' => url()->previous()]);
            return response()->json([
                'status' => false,
            ]);

        }else{

            $product = Product::where('id', $request->id)->first();

            if($product == null){
                return response()->json([
                    'status' => true,
                    'message' => '<div class="alert alert-danger">Product not found</div>',
                ]);
            }

            Wishlist::updateOrCreate(
                [
                    'user_id' => Auth::user()->id,
                    'product_id' => $request->id
                ],
                [
                    'user_id' => Auth::user()->id,
                    'product_id' => $request->id
                ]);




            return response()->json([
                'status' => true,
                'message' => '<div class="alert alert-success"><strong>"'.$product->title.'"</strong> added in you wishlist</div>',
            ]);
        }
    }

    public function page($slug){
        $pages =  Page::where('slug', $slug)->first();

        if (!$pages) {
            // Có thể chuyển hướng hoặc trả về một trang lỗi tùy chỉnh
            return redirect()->route('front.home')->with('error', 'Page not found.');
        }
        return view('front-end.pages', compact('pages'));

    }

    public function sendContactEmail(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'subject' =>'required'
        ]);

        if($validator->passes()){

            // send email here
            $mailData = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'mail_subject' => 'You have received a contact email'
            ];

            $email = env('ADMIN_EMAIL');


            Mail::to($email)->send( new ContactEmail($mailData));
            return response()->json([
                'status' => true,
                'message' => 'Your feedback has been sent successfully.'
            ]);
        }else{
            return response()->json([
                'status'=> false,
                'errors' => $validator->errors(),
            ]);
        }
    }
}
