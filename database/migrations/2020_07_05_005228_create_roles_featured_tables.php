<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesFeaturedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });
        Schema::create('role_permission_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('permission_id')
                ->constrained()
                ->onDelete('cascade');
            $table->unique('role_id', 'permission_id');
        });
        Schema::create('user_role_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('role_id')
                ->constrained()
                ->onDelete('cascade');
            $table->unique('user_id', 'role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_permission_pivot');
        Schema::dropIfExists('user_role_pivot');
    }
}
