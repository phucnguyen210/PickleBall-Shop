<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
    }
    public function show(Request $request)
    {
        $query = Brand::query()->latest();
        if ($request->has('keyword') && (!empty($request->keyword))) {
            $searchTerm = $request->keyword;
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $brand = $query->paginate(10);
        return view('admin.Brands.list', compact('brand'));
    }

    public function create(Request $request)
    {
        return view('admin.Brands.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:brands',
            'status' => 'required'

        ]);
        if ($validator->passes()) {
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            Session::flash('success', 'Brand created successfully');
            return response()->json([
                'status' => true,
                'message' => 'Brand created successfully',
            ]);
        }
    }
    public function edit(Request $request, $id)
    {
        $brand = Brand::find($id);
        if(empty($brand)){
            Session::flash('error', 'Brand not found!');
            return redirect()->route('brand.show');
        }else{
            return view('admin.Brands.edit', compact('brand'));
        }
    }
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            Session::flash('error', 'Brand not found');
            return response([
                'status' => false,
                'notFound' => true,
            ]);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required|unique:brands',
            'status' => 'required'

        ]);
        if ($validator->passes()) {

            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            $brand->save();

            Session::flash('success', 'Brand created successfully');
            return response()->json([
                'status' => true,
                'message' => 'Brand created successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => $validator->errors(),
            ]);
        }
    }
    public function destroy(Request $request, $id)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            Session::flash('error', 'Brand not found!');

            return response([
                'notFound' => true,
            ]);
        }
        $brand->delete();
        Session::flash('success', 'Deleted brand successfully');
        return response([
            'status' => 'success',
        ]);
    }
}
