<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    public function up(){
        Schema::create('wallets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->string("name");
            $table->string('project_api_url')->nullable();
            $table->uuid('currency_id');
            $table->uuid('firm_id')->nullable();
            $table->uuid('parent_id')->nullable();

            $table->index(['id','currency_id','firm_id','parent_id']);
            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('firm_id')
                ->references('id')
                ->on('firms')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
        
        Schema::table('wallets',function (Blueprint $table){
            $table->foreign('parent_id')
                ->references('id')
                ->on('wallets')
                ->onUpdate('cascade')
                ->onDelete('cascade');    
        });
    }

    public function down(){
        Schema::dropIfExists('wallets');
    }
}
