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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('orderNumber')->unsigned();
            $table->foreign('orderNumber')->references('orderNumber')->on('orders')->onDelete('cascade');
            $table->bigInteger('productNumber')->unsigned();
            $table->foreign('productNumber')->references('productNumber')->on('products');
            $table->string('productCode',100);
            $table->integer('quantityOrdered');
            $table->decimal('priceEach',7,2);
            $table->integer('orderLineNumber')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->index(['id','orderNumber','productCode']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
