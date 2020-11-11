<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_detail_id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('quantity')->default(0);
            $table->double('price', 10, 2)->default(0);
            $table->double('total_price', 10, 2)->default(0);
            $table->unsignedBigInteger('invoice_id');
            $table->timestamps();

            $table->foreign('product_detail_id')
                ->references('id')
                ->on('product_details')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
