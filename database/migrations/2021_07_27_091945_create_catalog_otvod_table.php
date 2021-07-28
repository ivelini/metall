<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogOtvodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_otvod', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->decimal('du');
            $table->decimal('h');
            $table->decimal('ugol_giba');
            $table->unsignedBigInteger('catalog_standart_product_id');
            $table->unsignedBigInteger('catalog_marka_stali_id');
            $table->string('ed_izm');
            $table->decimal('price_za_ed');
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('company')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('catalog_standart_product_id')->references('id')
                ->on('catalog_standart_product')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('catalog_marka_stali_id')->references('id')
                ->on('catalog_marka_stali')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_otvod');
    }
}
