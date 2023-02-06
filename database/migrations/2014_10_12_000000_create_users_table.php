<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->foreignId('branch_id')->nullable()->constrained('branches', 'id')->cascadeOnUpdate()->nullOnDelete();

            //FOR HOME SCREEN
            // -1 => SUPER_ADMIN
            // 0 => ADMIN
            // 1 => NORMAL USER
            $table->enum('type', ['-1', '0', '1'])->default('1');

            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('photoPath')->nullable();
            $table->string('username')->unique();
            $table->string('password');

            $table->enum('locale', ['en', 'ar'])->default('ar');

            $table->enum('status', ['0', '1'])->default('1');
            $table->enum('visible', ['0', '1'])->default('1');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
