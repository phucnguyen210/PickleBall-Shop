<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

use function Laravel\Prompts\error;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $product = Product::latest('id')->with('product_images'); // truy vấn tới bảng product, sắp xếp thứ thự theo trường Id, nạp trước các trường liên quan đến từng sản phẩm

        if ($request->has('keyword') && !empty($request->keyword)) {
            $searchTerm = $request->keyword;
            $product->where('products.title', 'like', '%' . $searchTerm . '%');
        }
        $products = $product->paginate();

        return view('admin.products.list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name', 'ASC')->get();
        $brands = Brand::orderBy('name', 'ASC')->get();

        $data['categories'] = $categories;
        $data['brands'] = $brands;
        return view('admin.products.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products',
            'description' => 'required',
            'short_description' => 'required',
            'price' => 'required',
            'sku' => 'required|unique:products,sku',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No'

        ];
        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $product = new Product();
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->shipping_returns = $request->shippings_return;
            $product->sku = $request->sku;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->track_qty = $request->track_qty;
            $product->barcode = $request->barcode;
            $product->qty = $request->qty;
            $product->status = $request->status;

            // nếu $request->related_products không rỗng thì trả về cho '$related_product' một chuỗi được ngăn cách bởi dấu phẩy

            $product->related_product = (!empty($request->related_products)) ? implode(',', $request->related_products) : '';
            $product->save();

            // Product garllery save
            if (!empty($request->image_array)) {
                foreach ($request->image_array as $temp_image_id) {
                    $tempImageInfo = TempImage::find($temp_image_id);
                    $extArray = explode('.', $tempImageInfo->name);  // phân tách tên của ảnh thành 1 mảng gồm 2 phần (trước và sau dấu '.')
                    $ext = last($extArray);


                    $productImage = new ProductImage();
                    $productImage->product_id =  $product->id;
                    $productImage->image =  'NULL';
                    $productImage->save();

                    $imageName = $product->id . '-' . $productImage->id . '-' . time() . '.' . $ext; // tạo tên mới cho image
                    $productImage->image = $imageName; // gán tên mới vào cột image trong bảng ProductImage
                    $productImage->save();

                    // Taọ hình ảnh thu nhỏ cho sản phẩm

                    // Large image
                    $sourcePath = public_path() . '/temp/' . $tempImageInfo->name;
                    $destPathLarge = public_path() . '/uploads/product/large/' . $imageName;
                    $image = Image::make($sourcePath);
                    $image->resize(1400, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->orientate();
                    $image->save($destPathLarge);

                    // Small image
                    $destPathSmall = public_path() . '/uploads/product/small/' . $imageName;
                    $image = Image::make($sourcePath);
                    $image->resize(300, 300, function ($constraint) {
                        $constraint->aspectRatio();
                    })->orientate();
                    $image->save($destPathSmall);
                }
            }

            Session::flash('success', 'Product added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Product added successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return view('admin.products.profile');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            Session::flash('error', 'Product not found!');
            return redirect()->route('product.index');
        }
        // fetch product iamge
        $productImage = ProductImage::where('product_id', $product->id)->get();
        $subCategory = SubCategory::where('category_id', $product->category_id)->get();

        $category = Category::with('sub_categories')->orderBy('name', 'ASC')->get();
        $brand = Brand::orderBy('name', 'ASC')->get();

        // fetch product iamge
        $relatedProduct = [];
        if ($product->related_product != "") {
            $relatedProductArray = explode(',', $product->related_product);
            $relatedProduct = Product::whereIn('id', $relatedProductArray)->get();
        }


        return view('admin.products.edit', compact('category', 'brand', 'product', 'productImage', 'relatedProduct'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Product not found!'

            ]);
        }


        $rules = [
            'title' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id . ',id', //khi kiểm tra tính duy nhất, bỏ qua bản ghi hiện tại có id là $product->id.
            'description' => 'required',
            'short_description' => 'required',
            'price' => 'required',
            'sku' => 'required|unique:products,sku,' . $product->id . ',id', //khi kiểm tra tính duy nhất, bỏ qua bản ghi hiện tại có id là $product->id.
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'is_featured' => 'required|in:Yes,No'

        ];
        if (!empty($request->track_qty) && $request->track_qty == 'Yes') {
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $product->title = $request->title;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->shipping_returns = $request->shipping_returns;
            $product->sku = $request->sku;
            $product->price = $request->price;
            $product->compare_price = $request->compare_price;
            $product->category_id = $request->category;
            $product->sub_category_id = $request->sub_category;
            $product->brand_id = $request->brand;
            $product->is_featured = $request->is_featured;
            $product->track_qty = $request->track_qty;
            $product->barcode = $request->barcode;
            $product->qty = $request->qty;
            $product->status = $request->status;

            // nếu $request->related_products không rỗng thì trả về cho '$related_product' một chuỗi được ngăn cách bởi dấu phẩy
            $product->related_product = (!empty($request->related_products)) ? implode(',', $request->related_products) : '';

            $product->save();



            // Product garllery save


            Session::flash('success', 'Product updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Product updated successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (empty($product)) {
            Session::flash('error', 'Product not found');
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Product not found'
            ]);
        }

        $imageProduct = ProductImage::where('product_id', $product->id)->get();
        if (!empty($imageProduct)) {
            foreach ($imageProduct as $imageProducts) {
                File::delete(public_path('uploads/product/large/' . $imageProducts->image));
                File::delete(public_path('uploads/product/small/' . $imageProducts->image));
            }
        }

        $product->delete();
        Session::flash('success', 'Product deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }
    public function getProduct(Request $request)
    {

        $term = $request->term;
        $termProduct = [];
        if ($term != "") {
            $products = Product::where('title', 'like', '%' . $term . '%')->get();
            if ($products != null) {
                foreach ($products as $product) {
                    $termProduct[] = array('id' => $product->id, 'text' => $product->title);
                }
            }
        }
        return response()->json([
            'tags' =>  $termProduct,
            'status' => true,
        ]);
    }
}
