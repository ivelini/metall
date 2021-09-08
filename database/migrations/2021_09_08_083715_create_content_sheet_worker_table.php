<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentSheetWorkerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_sheet_worker', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('content_sheet_worker_category_id');
            $table->string('position');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->timestamps();

            $table->foreign('content_sheet_worker_category_id')->references('id')
                ->on('content_sheet_worker_category')
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
        Schema::dropIfExists('content_sheet_worker');
    }
}
