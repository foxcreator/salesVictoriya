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
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('barcode')->unique();
            $table->string('unit');
            $table->decimal('price', 8, 2);
            $table->decimal('opt_price', 8, 2);
            $table->decimal('quantity', 6, 3);
            $table->string('thumbnail')->nullable();
            $table->string('on_sale')->default('1');
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
