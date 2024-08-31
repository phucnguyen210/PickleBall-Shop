<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index(){
        $pages = Page::latest()->get();
        return view('admin.pages.list', compact('pages'));
    }

    public function create(){
        return view('admin.pages.create');
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required'
        ]);

        if($validator->passes()){
            $page = new Page;
            $page->name = $request->name;
            $page->slug = $request->slug;
            $page->content = $request->content;
            $page->status = $request->status;
            $page->save();

            return response()->json([
                'status' => true,
                'message' => 'Page added successfully'

            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit(Request $request, $id){
        $pages = Page::find($id);
        return view('admin.pages.edit', compact('pages'));
    }

    public function update(Request $request){

    }
    public function destroy(Request $request){

    }

}
