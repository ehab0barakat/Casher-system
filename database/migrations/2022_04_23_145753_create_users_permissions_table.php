<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_permissions', function (Blueprint $table) {

            $table->foreignId('user_id')->constrained('users', 'id')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('permission_id')->constrained('permissions', 'id')->cascadeOnUpdate()->cascadeOnDelete();

            $table->primary(['user_id', 'permission_id']);

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
        Schema::dropIfExists('users_permissions');
    }
}
