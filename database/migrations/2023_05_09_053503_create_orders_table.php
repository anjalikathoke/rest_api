<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('orderNumber');
            $table->date('orderDate');
            $table->date('requiredDate')->nullable();
            $table->date('shippedDate')->nullable();
            $table->enum('status',['Ordered','Pending','Shipped','Canceled','Delivered'])->default('Pending');
            $table->string('comments')->nullable();
            $table->bigInteger('customerNumber')->unsigned();
            $table->foreign('customerNumber')->references('customerNumber')->on('customers')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
            $table->index(['orderNumber','customerNumber']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
