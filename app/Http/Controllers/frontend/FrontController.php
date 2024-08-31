<?php

namespace App\Http\Controllers\frontend;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
            // $user_id = auth::user();
            // $wishlist = new Wishlist();
            // $wishlist->product_id = $request->id;
            // $wishlist->user_id = $user_id->id;
            // $wishlist->save();



            return response()->json([
                'status' => true,
                'message' => '<div class="alert alert-success"><strong>"'.$product->title.'"</strong> added in you wishlist</div>',
            ]);
        }
    }
}
