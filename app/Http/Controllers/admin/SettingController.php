<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function showChangePasswordForm(){
        return view('admin.change-password');
    }

    public function processChangePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password'
        ]);

        if($validator->passes()){
            $admin = User::where('id', Auth::guard('admin')->user()->id)->first();
            if(Hash::check($request->old_password, $admin->password)){

                User::where('id', Auth::guard('admin')->user()->id)->update([
                    'password' => Hash::make($request->new_password)
                ]);
                session()->flash('success', 'You have change password successfully');
                return response()->json([
                    'status' => true
                ]);

            }else{
                session()->flash('error', 'You old password is incorrect, pleass try again.');
                return response()->json([
                    'status' => true
                ]);
            }
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);

        }
    }
}
