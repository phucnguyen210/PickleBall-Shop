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
        Schema::table('discount_coupons', function (Blueprint $table) {
            $table->renameColumn('expries_at', 'expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    
        Schema::table('discount_coupons', function (Blueprint $table) {
            $table->renameColumn('expires_at', 'expries_at');
        });
    }
};
