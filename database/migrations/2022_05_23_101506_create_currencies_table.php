<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    public function up(){
        Schema::create('currencies', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->string('code');
            $table->string('ccy');
            $table->string('ccnm_ru');
            $table->string('ccnm_uz');
            $table->string('ccnm_uzc');
            $table->string('ccnm_en');
        });
    }

    public function down(){
        Schema::dropIfExists('currencies');
    }
}
