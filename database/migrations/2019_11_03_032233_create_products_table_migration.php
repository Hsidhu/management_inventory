<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->text('document')->nullable();
            $table->integer('alert_level')->nullable();
            $table->string('barcode')->nullable();
            $table->string('reference')->nullable();
            $table->unsignedinteger('product_category_id');
            
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('product_category_id')->references('id')->on('product_categories');
        });

        Schema::create('product_balances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('stock')->default(0); 
            $table->unsignedInteger('stock_defective')->default(0);
            $table->timestamps();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_balances');
    }
}
