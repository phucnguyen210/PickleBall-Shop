<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

use Ramsey\Uuid\Uuid;

class ProductImageController extends Controller
{
    public function index(Request $request){

    }

    public function create(Request $request){

    }

    public function store(Request $request){

    }

    public function show(Request $request, $id){

    }

    public function edit(Request $request, $id){

    }

    public function update(Request $request){

        $image = $request->image;
        $ext = $image->getClientOriginalExtension(); // lấy phần mở rộng của tệp vd: jpg, jpeg,...
        $sourcePath = $image->getPathName();

        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image =  'NULL';
        $productImage->save();


        $imageName = $request->product_id.'-'.$productImage->id.'-'.time(). '.' .$ext; // tạo tên mới cho image
        $productImage->image = $imageName; // gán tên mới vào cột image trong bảng ProductImage
        $productImage->save();

         // Large image

        $destPathLarge = public_path().'/uploads/product/large/'. $imageName;
        $image = Image::make($sourcePath);
        $image->resize(1400, null, function($constraint){
            $constraint->aspectRatio();
        })->orientate();
        $image->save($destPathLarge);

         // Small image
        $destPathSmall = public_path().'/uploads/product/small/'.$imageName;
        $image = Image::make($sourcePath);
        // $image->resize(300, 300, function($constraint){
        //     $constraint->aspectRatio();
        // })->orientate()
        $image->resize(300, 300, function ($constraint) {
            // $constraint->aspectRatio();
            // $constraint->upsize();
        })->orientate();;
        $image->save($destPathSmall);


        return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'imagePath' => asset('uploads/product/small/'.$productImage->image),

            'message' => 'Image updated successfully',
        ]);

    }

    public function destroy(Request $request){
        $productImage = ProductImage::find($request->id);
        if(empty($productImage)){
            return response()->json([
                'status'=>false,
                'message' => 'Image not found'
            ]);
        }

        File::delete(public_path('uploads/product/large/'.$productImage->image));
        File::delete(public_path('uploads/product/small/'.$productImage->image));
        $productImage->delete();

        return response()->json([
            'status'=>true,
            'message'=> 'Image deleted successfully'
        ]);

    }
}
