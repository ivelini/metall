<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentSheetPageInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_sheet_page_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('sheet_name');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('h1')->nullable();
            $table->string('description')->nullable();
            $table->text('content')->nullable();
            $table->string('keywords')->nullable();
            $table->timestamps();

            $table->foreign('company_id')->references('id')
                ->on('company')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_sheet_page_information');
    }
}
