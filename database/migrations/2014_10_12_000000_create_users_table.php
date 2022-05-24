<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up(){
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('lang',3)->default('en');
        });
    }

    public function down(){
        Schema::dropIfExists('users');
    }
}
