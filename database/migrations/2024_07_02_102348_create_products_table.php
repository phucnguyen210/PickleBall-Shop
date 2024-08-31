<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('description')->nullable();
            $table->double('price', 10, 2);
            $table->double('compare_price', 10, 2)->nullable(); // Dùng để so sánh giá, vd: giá cũ trước khi giảm giá
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('is_featured', ['Yes', 'No'])->default('No'); // Xác định sản phẩm có nổi bật hay không
            $table->string('sku'); //Lưu trữ mã SKU (Stock Keeping Unit) | mã duy nhất cho mỗi sản phẩm, giúp dễ phân biệt và quản lý các sản phẩm khác nhau kể cả khi trùng tên.
            $table->string('barcode')->nullable(); // lưu mã vạch của sản phẩm
            $table->enum('track_qty', ['Yes', 'No'])->default('Yes'); //Xác định xem hệ thống có theo dõi số lượng sản phẩm hay không.
            $table->integer('qty')->nullable(); // quantity | lưu trữ số lượng
            $table->integer('status')->default(1);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
