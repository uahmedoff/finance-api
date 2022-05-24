<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryTable extends Migration
{
    public function up(){
        Schema::create('history', function (Blueprint $table) {
            $table->uuid('id')->primary()->id();
            $table->timestamp('created_at');
            $table->uuid('historiable_id');
            $table->string('historiable_type');
            $table->unsignedInteger('status');
            $table->json('details')->nullable();
        });
    }

    public function down(){
        Schema::dropIfExists('history');
    }
}
