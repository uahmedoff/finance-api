<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletTable extends Migration
{
    public function up(){
        Schema::create('user_wallet', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('wallet_id');
            $table->timestamp('created_at');
            $table->uuid('created_by')->nullable();
            $table->primary(['user_id','wallet_id']);
            $table->index(['user_id','wallet_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDElete('cascade');
            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets')
                ->onUpdate('cascade')
                ->onDelete('cascade');    
        });
    }

    public function down(){
        Schema::dropIfExists('user_wallet');
    }
}
