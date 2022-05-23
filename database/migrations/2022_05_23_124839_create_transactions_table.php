<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up(){
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->uuid('wallet_id')->index();
            $table->uuid('category_id')->index();
            $table->uuid('payment_method_id')->index();
            $table->date('date');
            $table->float('debit',20,2)->nullable();
            $table->float('credit',20,2)->nullable();
            $table->string('image')->nullable();
            $table->text('note')->nullable();
            
            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');    
            $table->foreign('payment_method_id')
                ->references('id')
                ->on('payment_methods')
                ->onUpdate('cascade')
                ->onDelete('cascade');    
        });
    }

    public function down(){
        Schema::dropIfExists('transactions');
    }
}
