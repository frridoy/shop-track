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
            $table->string('entry_no')->nullable()->index();
            $table->string('product_name', 100);
            $table->string('product_code', 50)->unique();
            $table->string('color', 50)->nullable();
            $table->string('size', 50)->nullable();
            $table->string('stock_qty', 20)->default(0);
            $table->string('sold_qty', 20)->default(0);
            $table->decimal('purchase_price', 12, 2)->default(0);
            $table->decimal('selling_price', 12, 2)->default(0);
            $table->decimal('bottom_price', 12, 2)->default(0);
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
