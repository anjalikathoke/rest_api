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
            $table->id('productNumber');
            $table->string('productCode',100)->unique();
            $table->string('productName', 100);
            $table->string('productImage', 555)->nullable();
            $table->string('productLine', 100)->nullable();
            $table->string('productScale', 100)->nullable();
            $table->string('productVendor', 100)->nullable();
            $table->text('productDescription');
            $table->integer('quantityInStock');
            $table->decimal('buyPrice',7,2);
            $table->decimal('MSRP',7,2);
            $table->softDeletes();
            $table->timestamps();
            $table->index('productCode');
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
