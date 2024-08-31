<?php

use App\Mail\OrderMail;
use App\Models\Category;
use App\Models\Country;
use App\Models\Order;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

    function getCategory(){
        return Category::orderBy('name', 'ASC')->where('showHome', 'Yes')->where('status', 1)->with('sub_categories')->orderBy('id', 'DESC')->get();
    }

    function productImage($productId){
        return ProductImage::where('product_id', $productId)->first();
    }

    if(!function_exists('formatPhoneNumber')){

        function formatPhoneNumber($phone){
            $phone = preg_replace('/[^0-9]/', '', $phone);
            if(strlen($phone) >= 9){
                $formattedPhone = '('.substr($phone,0, 3).') '.substr($phone, 3);
                return $formattedPhone;
            }
        }
    }

    function orderMail($orderId, $userType="customer"){
        $order = Order::where('id', $orderId)->with('order_items')->first();

        if($userType == "customer"){

            $subject = 'Thank for you order';
            $email = $order->email;

        }else{

            $subject = 'You have received a new order';
            $email = env('ADMIN_EMAIL');

        }
        $mailData = [
            'subject' =>  $subject,
            'order' => $order,
            'userType' => $userType,
        ];
        // dd(config('mail.mailers.smtp'));
        //   dd([
        //         'MAIL_HOST' => config('mail.mailers.smtp.host'),
        //         'MAIL_PORT' => config('mail.mailers.smtp.port'),
        //         'username' => config('mail.mailers.smtp.username'),
        //         'ADMIN_EMAIL' => env('ADMIN_EMAIL'),
        //         'example_check' => env('APP_NAME'),
        //         'name' => config('app.name'),
        //         'env' => config('app.env'),
        //         'debug' => config('app.debug'),
        //         'url' => config('app.url'),
        //         'key' => config('app.key'),

        //     ]);

        Mail::to($email)->send(new OrderMail($mailData));

    }

    function getCountry($id){
        $country = Country::where('id', $id)->first();
        return $country;

    }
?>
