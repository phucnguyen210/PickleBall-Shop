<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index()
    {
    }
    public function show(Request $request)
    {

        /* lấy tất cả các cột trong bảng 'sub_categories' và lấy giá trị 'name' trong bảng 'categories' và đặt tên cột là categoryName
            với điều kiện là 'categories.id' = 'sub_categories.category_id' thì mới lấy giá trị 'name' trong trường đó gán vào cột categoryName
        */
        $sub_categories = SubCategory::select('sub_categories.*', 'categories.name as categoryName')
            ->latest('sub_categories.id')
            ->leftJoin('categories', 'categories.id', 'sub_categories.category_id');

        if ($request->has('keyword') && !empty($request->keyword)) {
            $searchTerm = $request->keyword;
            $sub_categories->where('sub_categories.name', 'like', '%' . $searchTerm . '%')->orwhere('categories.name', 'like', '%' . $searchTerm . '%');
        }

        $sub_category =  $sub_categories->paginate(10);
        return view('admin.sub_category.list', compact('sub_category'));
    }

    public function create()
    {
        $category = Category::orderBy('name', 'ASC')->get(); // lấy dữ liệu từ bảng category sau khi sắp xếp các bản ghi 'name' (theo chiều tăng dần ASC)
        return view('admin.sub_category.create', compact('category'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            $sub_category = new SubCategory();
            $sub_category->name  = $request->name;
            $sub_category->slug  = $request->slug;
            $sub_category->category_id  = $request->category;
            $sub_category->status  = $request->status;
            $sub_category->showHome  = $request->showHome;

            $sub_category->save();

            Session::flash('success', 'Sub Category added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Sub Category added successfully',

            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit($id)
    {
        $category = Category::orderBy('name', 'ASC')->get();

        $sub_category = SubCategory::findOrFail($id);
        return view('admin.sub_category.edit', compact('sub_category', 'category'));
    }

    public function update(Request $request, $id)
    {

        $sub_category = SubCategory::find($id);
        if (!($sub_category)) {
            Session::flash('error', 'Sub category not found!');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:sub_categories',
            'category' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            $sub_category->name  = $request->name;
            $sub_category->slug  = $request->slug;
            $sub_category->category_id  = $request->category;
            $sub_category->status  = $request->status;
            $sub_category->showHome  = $request->showHome;
            $sub_category->save();

            Session::flash('success', 'Sub Category updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Sub Category updated successfully',

            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function destroy($id)
    {

        $subCategory = SubCategory::find($id);
        if (empty($subCategory)) {
            Session::flash('error', 'Delete Sub Category not found');
            return response([
                'notFound' => true,
                'status' => false,

            ]);
        }
        $subCategory->delete();
        Session::flash('success', 'Delete Sub Category successfully');
        return response()->json([
            'status' => 'success',
        ]);
    }
}
