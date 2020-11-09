<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_detail_id');
            $table->unsignedBigInteger('product_class_id');
            $table->timestamps();

            $table->foreign('product_detail_id')
                ->references('id')
                ->on('product_details')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('product_class_id')
                ->references('id')
                ->on('product_classifications')
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
        Schema::dropIfExists('product_variants');
    }
}
