<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCatalogProductCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('catalog_product_category', function (Blueprint $table) {
            $table->string('synonymizer_title')->nullable();
            $table->string('synonymizer_description')->nullable();
            $table->text('synonymizer_content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('catalog_product_category', function (Blueprint $table) {
            $table->dropColumn(['description', 'synonymizer_title', 'synonymizer_description', 'synonymizer_content']);
        });
    }
}
