<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentSheetShipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_sheet_shipment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('h1');
            $table->string('slug');
            $table->date('date');
            $table->string('point');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->text('description')->nullable();
            $table->json('products_json')->nullable();
            $table->boolean('is_published')->default('0');
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
        Schema::dropIfExists('content_sheet_shipment');
    }
}
