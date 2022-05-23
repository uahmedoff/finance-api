<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRatesTable extends Migration
{
    public function up(){
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->timestamps();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('currency_id')->index();
            $table->date('date');
            $table->float('rate',20,2);

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('exchange_rates');
    }
}
