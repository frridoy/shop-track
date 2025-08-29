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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('branch_name');
            $table->string('branch_code')->nullable();
            $table->string('branch_email')->nullable();
            $table->string('branch_contact')->nullable();
            $table->string('branch_address')->nullable();
            $table->string('created_by')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.9
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
