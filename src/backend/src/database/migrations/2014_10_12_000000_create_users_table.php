<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('assignable')->default(0);
            $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('profile_id',false,true)->default(1);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('oauth')->default(0);
            $table->tinyInteger('activo')->default(1);
            $table->tinyInteger('backend')->default(0);
            $table->string('f_token')->nullable();
            $table->string('g_token')->nullable();
            $table->string('t_token')->nullable();
            $table->string('telefono')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->index(["email","password"]);
            $table->foreign('profile_id')->references('id')->on('profile')->onDelete('restrict')->onUpdate('cascade');
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
}
