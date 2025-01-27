<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatalogProductCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_product_category', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->default('0');
            $table->unsignedBigInteger('company_id');
            $table->string('category_name');
            $table->string('title')->nullable();
            $table->string('h1')->nullable();
            $table->string('slug')->nullable();
            $table->string('description')->nullable();
            $table->string('catalog_product_table_name')->nullable();
            $table->string('columns_name')->nullable();
            $table->boolean('is_published')->default('0');
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('company')
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
        Schema::dropIfExists('catalog_product_category');
    }
}
