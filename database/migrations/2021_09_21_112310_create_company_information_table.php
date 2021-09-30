<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('full_name')->nullable();
            $table->string('slim_name')->nullable();
            $table->string('index')->nullable();
            $table->string('oreal')->nullable();
            $table->string('sity')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->json('storages_json')->nullable();
            $table->json('agency_json')->nullable();
            $table->string('map')->nullable();

            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('company')
                ->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_information');
    }
}
