<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TempImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Category::query()->latest();

        if ($request->has('keyword') && !empty($request->keyword)) {
            $searchTerm = $request->keyword;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }
        $categories = $query->paginate(10);

        return view('admin.categories.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories',
        ]);

        if ($validator->passes()) {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;
            $category->save();

            Session::flash('success', 'Category added successfully');

            // Save image here

            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name); // phân tách tên của ảnh thành 1 mảng gồm 2 phần (trước và sau dấu '.')
                $ext = last($extArray); // lấy phần cuối của mảng(phần sau dấu .)

                $newImageName = $category->id . '.' . $ext;
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/category/' . $newImageName;
                File::copy($sPath, $dPath);

                // Tạo hình thu nhỏ hình ảnh (Generate Image Thumbnail)

                // create instance
                $dPath = public_path() . '/uploads/category/thumb/' . $newImageName;
                $img = Image::make($sPath);
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->orientate();
                $img->save($dPath);


                $category->image = $newImageName;
                $category->save();
            }

            return response()->json([
                'status' => true,
                'success' => "Category added Successfully"
            ]);
        } else {
            return response()->json([
                'status' => false, // nếu không thỏa mãn các đk bắt buộc thì status sẽ được gán là false và gửi qua ajax để xử lý
                'errors' => $validator->errors(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)

    {
        $categories = Category::findOrFail($id);
        if (empty($categories)) {
            Session::flash('error', 'categories not found!');
            return redirect()->route('admin.categories');
        } else {
            return view('admin.categories.edit', compact('categories'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $category = Category::findOrFail($id);
        if (empty($category)) {
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category not found!'
            ]);
        }


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,' . $category->id . ',id',
        ]);

        if ($validator->passes()) {

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->status = $request->status;
            $category->showHome = $request->showHome;

            $category->save();

            $oldImage = $category->image; // lấy ra tên của ảnh ban đầu



            // Save image here

            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name); // phân tách tên của ảnh thành 1 mảng gồm 2 phần (trước và sau dấu '.')
                $ext = last($extArray); // lấy phần cuối của mảng(phần sau dấu .)

                $newImageName = $category->id . '-' . time() . '.' . $ext; // đổi tên
                $sPath = public_path() . '/temp/' . $tempImage->name;
                $dPath = public_path() . '/uploads/category/' . $newImageName;
                File::copy($sPath, $dPath); // copy ảnh ở đường dẫn cũ chuyển sang đường dẫn mới

                // Tạo hình thu nhỏ hình ảnh (Generate Image Thumbnail)
                // create instance
                $dPath = public_path() . '/uploads/category/thumb/' . $newImageName;
                $img = Image::make($sPath);
                $img->fit(800, 600, function ($constraint) {
                    $constraint->upsize();
                });
                $img->save($dPath);


                $category->image = $newImageName;
                $category->save();

                //delete old image
                // sau khi đã lưu ảnh mới update thì xóa các ảnh cũ đi
                if ($oldImage) {
                    File::delete(public_path() . '/uploads/category/thumb/' . $oldImage);
                    File::delete(public_path() . '/uploads/category/' . $oldImage);
                }
            }

            Session::flash('success', 'Category updated successfully');

            return response()->json([
                'status' => true,
                'success' => "Category added Successfully"
            ]);
        } else {
            return response()->json([
                'status' => false, // nếu không thỏa mãn các đk bắt buộc thì status sẽ được gán là false và gửi qua ajax để xử lý
                'errors' => $validator->errors(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {


        try {
            $categories = Category::findOrFail($id);
            if (empty($categories)) {
                // Session::flash('error', 'Category not found!');

                return response()->json([
                    'status' => false,
                    'message' => 'Category not found'
                ]);
            }
            $imgName = $categories->image;
            $categories->delete();
            // delete image
            if (!empty($imgName)) {

                $imagePath = public_path('/uploads/category/' . $imgName);
                $thumbPath = public_path('/uploads/category/thumb/' . $imgName);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                if (File::exists($thumbPath)) {
                    File::delete($thumbPath);
                }

               
            }
            Session::flash('success', 'Category deleted successfully');
            return response()->json([
                'status' => true,
                'message' => 'Category deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}