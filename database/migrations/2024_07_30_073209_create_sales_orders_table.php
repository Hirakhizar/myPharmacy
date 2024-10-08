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
        Schema::create('sales_orders', function (Blueprint $table) {
            
            $table->id();
            $table->string('customer');
            $table->string('phone');
            $table->string('order_status')->default('pending');
            $table->enum('refund_status', ['Pending', 'Approved', 'Rejected', 'Completed','noRequest'])->default('noRequest');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};


