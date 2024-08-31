<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;


class ShippingController extends Controller
{
    public function create(){
        $countries = Country::get();

        $shippingCharges = ShippingCharge::select('shipping_charges.*', 'countries.name')
            ->leftJoin('countries','countries.id','shipping_charges.country_id')
            ->get();

        return view('admin.shipping.create', compact('countries', 'shippingCharges'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'country' => 'required',
            'amount' => 'required',
        ]);

        if($validator->passes()){

            $count = ShippingCharge::where('country_id', $request->country)->count();
            // dd($count);
            if($count > 0){

                Session::flash('error', 'Shipping already added');
                return response()->json([
                    'status' => true,
                    'message' => 'Shipping already added'
                ]);
            }
            $shipping = new ShippingCharge();
            $shipping->country_id = $request->country;
            $shipping->amount = $request->amount;
            $shipping ->save();

            Session::flash('success', 'Shipping added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Shipping added successfully'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Shipping false'

            ]);
        }

    }
    public function show(){
        return view('admin.shipping.list');
    }


    public function edit($id){
        $countries = Country::get();
        $shippingCharges = ShippingCharge::find($id);
        return view('admin.shipping.edit', compact('countries', 'shippingCharges'));
    }
    public function update($id, Request $request){
        $validator = Validator::make($request->all(),[
            'country' => 'required',
            'amount' => 'required',
        ]);

        if($validator->passes()){




            $shipping = ShippingCharge::find($id);
            $shipping->country_id = $request->country;
            $shipping->amount = $request->amount;
            $shipping ->save();

            Session::flash('success', 'Shipping updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Shipping updated successfully'

            ]);


        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
                'message' => 'Shipping false'

            ]);
        }
    }
    public function destroy($id){
        $shippingCharges = ShippingCharge::find($id);

        if(empty($shippingCharges)){
            return response()->json([
                'status' => false,
                'message' => 'true'
            ]);
        }

        $shippingCharges->delete();
        Session::flash('success', 'Shipping deleted successfully');

        return response()->json([
            'status' => true,
            'message' => 'Shipping deleted successfully'
        ]);
    }
}
