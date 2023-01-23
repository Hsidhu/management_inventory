<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // when finilized add sale or recipt id
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->unsignedInteger('received_product_id')->nullable();
            $table->unsignedInteger('sold_product_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->integer('qty');
            $table->timestamps();
            $table->foreign('received_product_id')->references('id')->on('received_products')->onDelete('cascade');
            $table->foreign('sold_product_id')->references('id')->on('sold_products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
