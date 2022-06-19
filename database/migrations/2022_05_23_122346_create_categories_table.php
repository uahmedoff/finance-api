<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up(){
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->uuid('deleted_by')->nullable();
            $table->uuid('wallet_id')->index();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('color')->default("#000000");
            $table->string('bgcolor')->default("#FFFFFF");
            $table->unsignedTinyInteger('type')->comment('1-Income, 2-Expense');
            $table->uuid('parent_id')->nullable()->index();
        });

        Schema::table('categories',function(Blueprint $table){
            $table->foreign('wallet_id')
                ->references('id')
                ->on('wallets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('parent_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    public function down(){
        Schema::dropIfExists('categories');
    }
}
