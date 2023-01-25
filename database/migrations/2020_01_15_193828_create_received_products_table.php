<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('receipt_id');
            $table->unsignedInteger('product_id');
            $table->integer('stock');
            $table->integer('stock_defective');
            $table->timestamp('expired_at')->nullable();
            $table->decimal('price', 10, 2);
            $table->foreign('receipt_id')->references('id')->on('receipts')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('received_products');
    }
}
