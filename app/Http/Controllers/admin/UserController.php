<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Dotenv\Parser\Value;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request){
        $users = User::where('role', 0)->latest();

        if($request->get('keyword') != ""){
            $users = $users->where('users.name', 'like', '%'.$request->keyword.'%');
            $users = $users->orWhere('users.email', 'like', '%'.$request->keyword.'%');
            $users = $users->orWhere('users.phone', 'like', '%'.$request->keyword.'%');
        }
        $users = $users->paginate(10);
        return view('admin.User.list', compact('users'));
    }

    public function create(){
        return view('admin.User.create');
    }
    public function store(Request $request){

        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'required|numeric'
        ]);

        if($validator->passes()){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->phone = $request->phone;

            $user->save();
            session()->flash('success', 'User added successfully');
            return response()->json([
                'status' => true,
                'message' => 'User added successfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

    }

    public function edit(Request $request, $id){
        $users = User::find($id);
        if( $users == null){
            session()->flash('error', 'User not found');
            return redirect()->route('user.index');

        }else{
            return view('admin.User.edit', compact('users'));

        }
    }

    public function update(Request $request, $id){

        $user = User::find($id);
        $validator = Validator::make( $request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'phone' => 'required|numeric'
        ]);

        if($validator->passes()){

            $user->name = $request->name;
            $user->email = $request->email;
            if($request->password != ''){
                $user->password = Hash::make($request->password);
            }
            $user->phone = $request->phone;
            $user->status = $request->status;
            $user->save();
            session()->flash('success', 'User updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'User updated successfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function delete(Request $request){
        $user = User::find($request->id);
        if($user != ''){
            $user->delete();
            session()->flash('success', 'User deleted successfully');
            return response()->json([
                'status' => true,
                'message' => 'User deleted successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

    }
}
