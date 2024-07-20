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
        Schema::create('medicines', function (Blueprint $table) {
            
            $table->id();
            $table->string('name')->nullable();
            $table->string('generic_name')->nullable();
            $table->string('sku')->nullable();
            $table->string('weight')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('manufacturer_id');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade');
            $table->string('price')->nullable();
            $table->string('manufacturer_price')->nullable();
            $table->string('stock')->nullable();
            $table->enum('status',['low','avaliable','out of stock'])->default('avaliable');
            $table->date('expire_date')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
