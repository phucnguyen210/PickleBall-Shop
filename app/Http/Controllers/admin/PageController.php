<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
    public function index(Request $request){
        $pages = Page::latest();
        if($request->get('keyword') != ''){
            $pages = $pages->where('pages.name', 'like', '%'.$request->keyword.'%');
        }
        $pages = $pages->paginate(10);
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

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required'
        ]);

        if($validator->passes()){
            $pages = Page::find($id);
            $pages->name = $request->name;
            $pages->slug = $request->slug;
            $pages->content = $request->content;
            $pages->status = $request->status;
            $pages->save();
            session()->flash('success', 'Page updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Page updated successfully'

            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

    }
    public function destroy(Request $request){
        $page = Page::find($request->id);
        if($page != ''){
            $page->delete();
            session()->flash('success', 'Page deleted successfully');
            return response()->json([
                'status' => true,
                'message' => 'Page deleted successfully'
            ]);

        }else{
            session()->flash('error', 'Page not found');
            return response()->json([
                'status' => false,
                'message' => 'Page not found'
            ]);
        }
    }

}
