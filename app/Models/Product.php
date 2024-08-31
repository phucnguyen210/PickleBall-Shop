<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function product_images(){
        return $this->hasMany(ProductImage::class); // thiết lập mối quan hệ 1 nhiều với bảng productImage
    }
    public function order_itmes(){
        return $this->hasMany(OrderItem::class); // thiết lập mối quan hệ 1 nhiều với bảng order_items
    }
}
