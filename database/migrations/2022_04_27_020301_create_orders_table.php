<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained('branches', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients', 'id')->cascadeOnUpdate()->nullOnDelete();
            $table->double('subtotal', 8, 2);
            $table->double('discount', 8, 2);
            $table->double('total', 8, 2);
            $table->enum('order_type',['0' , '1'])->default('0');  // 0 => order ,, 1 => return order

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
        Schema::dropIfExists('orders');
    }
}
