<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->unsignedBigInteger('content_sheet_standarts_id')->nullable();
            $table->unsignedBigInteger('price_company_information_id')->nullable();
            $table->unsignedBigInteger('requisites_company_information_id')->nullable();
            $table->timestamps();

            $table->foreign('content_sheet_standarts_id')->references('id')
                ->on('content_sheet_standarts')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('price_company_information_id')->references('id')
                ->on('company_information')->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreign('requisites_company_information_id')->references('id')
                ->on('company_information')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file');
    }
}
