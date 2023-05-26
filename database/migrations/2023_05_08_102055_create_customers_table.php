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
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customerNumber');
            $table->string('customerName',225)->nullable();
            $table->string('contactFirstName',100);
            $table->string('contactLastName',100);
            $table->string('phone',20);
            $table->string('addressLine1',250);
            $table->string('addressLine2',250);
            $table->string('city',50);
            $table->string('state',50);
            $table->string('postalCode',10);
            $table->string('country',100);
            $table->integer('salesRepEmployeeNumber')->nullable()->default(0);
            $table->integer('creditLimit')->nullable()->default(0);
            $table->enum('status', ['pending', 'active', 'deactive'])->nullable()->default('active');
            $table->softDeletes();
            $table->timestamps();
            $table->index('customerNumber');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
