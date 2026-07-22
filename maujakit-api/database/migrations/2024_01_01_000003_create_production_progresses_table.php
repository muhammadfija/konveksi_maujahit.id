<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_progresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->enum('status', [
                'ORDER_MASUK',
                'DP_PELUNASAN',
                'DESAIN',
                'BELI_BAHAN',
                'POTONG',
                'JAHIT',
                'QC',
                'PACKING',
                'KIRIM',
            ]);
            $table->string('photo_path')->nullable();
            $table->text('note')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('production_progresses');
    }
};
