<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();

            // 0 => NORMAL
            // 1 => RENT
            // 2 => SALARIES
            $table->enum('type', ['0', '1', '2']);

            // 0 => NORMAL      [NAME / COST]
            // 1 => RENT        [COST]
            // 2 => SALARIES    [WORKER_ID / COST]
            $table->string('metaData')->default('');

            $table->enum('status', ['0', '1'])->default('1');
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
        Schema::dropIfExists('expenses');
    }
}
