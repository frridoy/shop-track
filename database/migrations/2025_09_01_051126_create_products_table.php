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
            $table->foreignId('product_type_id')->constrained('product_types')->onDelete('cascade');
            $table->string('product_name', 100)->unique();
            $table->integer('product_qty')->default(0);
            $table->decimal('product_max_price', 10, 2)->nullable();
            $table->decimal('product_bottom_price', 10, 2);
            $table->string('remarks')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->tinyInteger('is_updated')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
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
