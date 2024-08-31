<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){

        $orders = Order::latest('orders.created_at')->select('orders.*', 'users.name', 'users.email');
        $orders = $orders->leftJoin('users', 'users.id', 'orders.user_id');

        if($request->get('keyword') != ""){
            $orders = $orders->where('users.name', 'like', '%'.$request->keyword.'%');
            $orders = $orders->orWhere('users.email', 'like', '%'.$request->keyword.'%');
            $orders = $orders->orWhere('orders.id', 'like', '%'.$request->keyword.'%');
        }

        $orders = $orders->paginate(10);



        return view('admin.orders.list', compact('orders'));
    }

    public function orderDetail(Request $request, $id){

        $order = Order::find($id);
        $orderItems = OrderItem::where('order_id', $id)->get();


        return view('admin.orders.order_detail', compact('orderItems', 'order'));

    }

    public function changeOrderStatus(Request $request, $id){
        $order = Order::find($id);

        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();

        return response()->json([
            'status' => true,
            'message' => 'Change Order status successfully'
        ]);

    }

    public function sendInoviceMail(Request $request, $id){
        orderMail($id, $request->userType);

        session()->flash('success','Order email send successfully');

        return response()->json([
            'status' => true,
            'message' => 'Order email send successfully'
        ]);
    }
}
