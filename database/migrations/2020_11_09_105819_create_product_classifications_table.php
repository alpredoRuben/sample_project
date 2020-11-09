<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_classifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classification_id');
            $table->string('name')->nullable();
            $table->text('value')->nullable();
            $table->timestamps();

            $table->foreign('classification_id')
                ->references('id')
                ->on('classifications')
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
        Schema::dropIfExists('product_classifications');
    }
}
