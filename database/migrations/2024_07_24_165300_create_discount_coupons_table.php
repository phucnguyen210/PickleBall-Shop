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
        Schema::create('discount_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name')->nullable();
            $table->text('description')->nullable();

            //số lần sử dụng tối đa
            $table->integer('max_uses')->nullable();
            // số lượng mã mà mỗi người được sử dụng
            $table->integer('max_uses_user')->nullable();

            // chọn loại giảm giá theo % hay giảm giá theo 1 số nhất định
            $table->enum('type', ['percent', 'fixed'])->default('fixed');

            // sau số thập phân sẽ là 2 số
            $table->double('discount_amount', 10, 2);
            $table->double('min_amount', 10, 2)->nullable();

            $table->integer('status')->default(1);

            // thời gian bắt đầu áp dụng
            $table->timestamp('start_at')->nullable();

            // thời gian kết thúc
            $table->timestamp('expries_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_coupons');
    }
};
