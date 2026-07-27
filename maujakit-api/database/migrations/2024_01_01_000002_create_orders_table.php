<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            $table->string('customer_name');
            $table->string('whatsapp');
            $table->string('company_name')->nullable();
            $table->string('product_type');
            $table->integer('quantity');
            $table->string('color');
            $table->text('notes')->nullable();
            $table->date('estimated_finish');
            $table->string('current_status', 30)->default('ORDER_MASUK');
            $table->string('resi_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
