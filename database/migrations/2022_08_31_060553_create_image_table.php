<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->unsignedBigInteger('catalog_product_category_id')->nullable();
            $table->unsignedBigInteger('content_record_category_id')->nullable();
            $table->unsignedBigInteger('content_record_id')->nullable();
            $table->unsignedBigInteger('content_sheet_worker_id')->nullable();
            $table->unsignedBigInteger('content_sheet_certificates_id')->nullable();
            $table->unsignedBigInteger('content_sheet_timeline_page_id')->nullable();
            $table->unsignedBigInteger('content_sheet_timeline_line_id')->nullable();
            $table->unsignedBigInteger('content_sheet_shipment_id')->nullable();
            $table->boolean('is_head')->default('0');
            $table->timestamps();

            $table->foreign('catalog_product_category_id')->references('id')
                ->on('catalog_product_category')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('content_record_category_id')->references('id')
                ->on('content_record_category')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('content_record_id')->references('id')
                ->on('content_record')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('content_sheet_worker_id')->references('id')
                ->on('content_sheet_worker')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('content_sheet_certificates_id')->references('id')
                ->on('content_sheet_certificates')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('content_sheet_timeline_page_id')->references('id')
                ->on('content_sheet_timeline_page')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('content_sheet_timeline_line_id')->references('id')
                ->on('content_sheet_timeline_line')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('content_sheet_shipment_id')->references('id')
                ->on('content_sheet_shipment')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image');
    }
}
