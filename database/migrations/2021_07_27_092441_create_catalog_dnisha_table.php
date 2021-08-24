<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogDnishaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_dnisha', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->decimal('du');
            $table->decimal('h');
            $table->unsignedBigInteger('catalog_standards_product_id');
            $table->unsignedBigInteger('catalog_marki_stali_id');
            $table->decimal('price')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('company')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('catalog_standards_product_id')->references('id')
                ->on('catalog_standards_product')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('catalog_marki_stali_id')->references('id')
                ->on('catalog_marki_stali')
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
        Schema::dropIfExists('catalog_dnisha');
    }
}
