<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ShopController extends Controller
{
    public function index(Request $request, $categorySlug = null, $subCategorySlug = null){
        $category = Category::where('status', 1)->with('sub_categories')->orderBy('name', 'ASC')->get();
        $brand = Brand::where('status', 1)->orderBy('name', 'ASC')->get();
        $products = Product::where('status', 1)->with('product_images');



        $categorySelected = '';
        $subCategorySelected = '';



        // Apply filters
        if(!empty($categorySlug)) {
            $categories = Category::where('slug', $categorySlug)->first();
            $products = $products-> where('category_id',  $categories->id);
            $categorySelected = $categories->id;
        }
        if(!empty($subCategorySlug)) {
            $sub_categories = SubCategory::where('slug', $subCategorySlug)->first();
            $products = $products-> where('sub_category_id',  $sub_categories->id);
            $subCategorySelected = $sub_categories->id;
        }
        if(!empty($request->get('search'))){
            $products = Product::where('title', 'like', '%'.$request->get('search').'%');
        }


        // Brand filter
        $brandArray = [];
        if ( !empty($request->get('brand')) ) { // lấy chuỗi brand trên url
            $brandArray = explode(',', $request->get('brand')); // phân tách chuỗi thành 1 mảng bằng dấu phẩy , sau đó gán giá trị vào cho mảng
            $products = $products->whereIn('brand_id', $brandArray); // lọc các sản phẩm theo danh sách ID brandArray
        }

        // Price range filter
        if($request->get('price_min') != '' && $request->get('price_max') != ''){
            if($request->get('price_max') == 10000){
                $products = $products->whereBetween('price', [ intval($request->get('price_min')), 100000 ] ); // so sánh trường price trong bảng xem có nằm trong price min-max không.

            } else{
                $products = $products->whereBetween('price', [ intval($request->get('price_min')), intval($request->get('price_max')) ] ); // so sánh trường price trong bảng xem có nằm trong price min-max không.

            }
        }

        // Sorting filter
        if(!empty($request->get('sort')) ) {

            if($request->get('sort') == 'price_desc'){
                $products = $products->orderBy('price', 'DESC');
            }
            else if($request->get('sort') == 'price_asc'){
                $products = $products->orderBy('price', 'ASC');
            }
        }


        $product = $products->orderBy('id', 'DESC')->paginate(6);
         // Limit the title length
         $product->getCollection()->transform(function ($product) {
            $product->title = Str::limit($product->title, 40);
            return $product;
        });


        $data['category'] =  $category;
        $data['brand'] =  $brand;
        $data['product'] =  $product;
        $data['categorySelected'] =  $categorySelected;
        $data['subCategorySelected'] =  $subCategorySelected;
        $data['brandArray'] = $brandArray;
        $data['price_Min'] = (intval($request->get('price_min')) ); // gán giá trị min vào biến để gọi lại bên client
        $data['price_Max'] = (intval($request->get('price_max')) == 0 ? 10000 : intval($request->get('price_max')) ); // gán giá trị max vào biến để gọi lại bên client
        $data['sort'] =  $request->get('sort');


        return view('front-end.shop', $data);
    }
    public function product($slug){

        $product = Product::where('slug', $slug)->with('product_images')->first();
        if($product == null){
            abort(404);
        }

        $relatedProduct = [];
        if($product->related_product != ""){
            $relatedProductArray = explode(',',$product->related_product);
            $relatedProduct = Product::whereIn('id', $relatedProductArray)->where('status', 1)->with('product_images')->get();
        }
        // dd($relatedProduct);

        return view('front-end.product', compact('product', 'relatedProduct'));




    }
}
