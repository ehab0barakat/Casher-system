<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->unsignedSmallInteger('quantity');
            $table->unsignedSmallInteger('price');
            $table->unsignedSmallInteger('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
