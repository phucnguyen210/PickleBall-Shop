<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class DiscountCodeController extends Controller
{
    public function index(Request $request){
        $query = DiscountCoupon::query()->latest();
        if ($request->has('keyword') && !empty($request->keyword)) {
            $searchTerm = $request->keyword;
            $query = $query->where('name', 'like', '%' . $searchTerm . '%');
            $query = $query->where('code', 'like', '%' . $searchTerm . '%');
        }
        $discountCoupon = $query->paginate(10);
        return view('admin.coupon.list', compact('discountCoupon'));
    }


    public function create(){
        return view('admin.coupon.create');
    }


    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'type' =>'required',
            'discount_amount' => 'required',
            'status' => 'required'

        ]);

        if($validator->passes()){


            // kiểm tra ngày bắt đầu
            if(!empty($request->start_at)){
                $now = Carbon::now();
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_at);

                if($startAt -> lte($now) == true){ //  kiểm tra xem startAt có nhỏ hơn thời gian hiện tại hay không bằng lte(less than or equal to)
                    return response()->json([
                        'status' => false,
                        'errors' =>['start_at' => 'Start date can not be less than current time'],
                    ]);

                }

            }

            // kiểm tra ngày kết thúc
            if(!empty($request->start_at) && !empty($request->expires_at)){
                $expriesAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_at);

                if($expriesAt -> gt($startAt) == false){ //  kiểm tra xem expriesAt có lớn hơn thời gian $startAt hay không bằng gt(greater than), nếu thời gian hết hạn nhỏ hơn thời gian bắt đầu thì trả về false còn if sẽ trả về true
                    return response()->json([
                        'status' => false,
                        'errors' =>['expires_at' => 'Expires date must be greater than Start at'],
                    ]);

                }

            }
            $discountCode = new DiscountCoupon();
            $discountCode->code = $request->code;
            $discountCode->name = $request->name;
            $discountCode->description = $request->description;
            $discountCode->max_uses = $request->max_uses;
            $discountCode->max_uses_user = $request->max_uses_user;
            $discountCode->type = $request->type;
            $discountCode->discount_amount = $request->discount_amount;
            $discountCode->min_amount = $request->min_amount;
            $discountCode->status = $request->status;
            $discountCode->start_at = $request->start_at;
            $discountCode->expires_at = $request->expires_at;
            $discountCode->save();

            Session::flash('success', 'Discount coupon added successfully');
            return response()->json([
                'status' => true,
                'message' => 'Discount coupon added successfully',
            ]);


        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }
    public function show(Request $request){

    }
    public function edit($id, Request $request){
        $discountCoupon = DiscountCoupon::find($id);
        return view('admin.coupon.edit', compact('discountCoupon'));

    }
    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'code' => 'required',
            'type' =>'required',
            'discount_amount' => 'required',
            'status' => 'required'

        ]);

        if($validator->passes()){

            $discountCode = DiscountCoupon::find($id);
            if( $discountCode == null){
                Session::flash('error', 'Discount coupon not found');
                return response()->json([
                    'status' => true,

                ]);
            }

            // kiểm tra ngày kết thúc
            if(!empty($request->start_at) && !empty($request->expires_at)){
                $expriesAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->expires_at);
                $startAt = Carbon::createFromFormat('Y-m-d H:i:s', $request->start_at);

                if($expriesAt -> gt($startAt) == false){ //  kiểm tra xem expriesAt có lớn hơn thời gian $startAt hay không bằng gt(greater than), nếu thời gian hết hạn nhỏ hơn thời gian bắt đầu thì trả về false còn if sẽ trả về true
                    return response()->json([
                        'status' => false,
                        'errors' =>['expires_at' => 'Expires date must be greater than Start at'],
                    ]);

                }

            }

            $discountCode->code = $request->code;
            $discountCode->name = $request->name;
            $discountCode->description = $request->description;
            $discountCode->max_uses = $request->max_uses;
            $discountCode->max_uses_user = $request->max_uses_user;
            $discountCode->type = $request->type;
            $discountCode->discount_amount = $request->discount_amount;
            $discountCode->min_amount = $request->min_amount;
            $discountCode->status = $request->status;
            $discountCode->start_at = $request->start_at;
            $discountCode->expires_at = $request->expires_at;
            $discountCode->save();
            Session::flash('success', 'Discount coupon updated successfully');
            return response()->json([
                'status' => true,
                'message' => 'Discount coupon updated successfully',
            ]);
        }
    }


    public function destroy(Request $request, $id){
        $discountCode = DiscountCoupon::find($id);

        if( empty($discountCode)){
            Session::flash('error', 'Discount coupon not found');
            return response()->json([
                'status' => true,
                'message' => 'Discount coupon not found'
            ]);
        }

        $discountCode -> delete();
        Session::flash('success', 'Discount coupon deleted successfully');
        return response()->json([
            'status' => true,
            'message' => 'Discount coupon deleted successfully',
        ]);
    }

}
