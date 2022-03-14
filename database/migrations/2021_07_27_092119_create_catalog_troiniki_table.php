<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogTroinikiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_troiniki', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->decimal('du1');
            $table->decimal('h1');
            $table->decimal('du2')->nullable();
            $table->decimal('h2')->nullable();
            $table->unsignedBigInteger('catalog_standards_product_id');
            $table->unsignedBigInteger('catalog_marki_stali_id');
            $table->string('ed_izm')->nullable();
            $table->decimal('price', $precision = 10, $scale = 2)->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('company')
                ->cascadeOnDelete();

            $table->foreign('catalog_standards_product_id')->references('id')
                ->on('catalog_standards_product')
                ->cascadeOnDelete();

            $table->foreign('catalog_marki_stali_id')->references('id')
                ->on('catalog_marki_stali')
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
        Schema::dropIfExists('catalog_troiniki');
    }
}
