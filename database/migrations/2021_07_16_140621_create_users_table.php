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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('telephone');
            $table->string('email')->unique(); // means can not use same email repeatedly
            $table->string('password');
            $table->string('cpassword');
            $table->string('image');
            $table->rememberToken();
            $table->timestamps();

            // now run the command -> "php artisan migrate"
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
