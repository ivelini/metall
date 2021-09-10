<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentSheetTimelineLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_sheet_timeline_line', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('timeline_page_id');
            $table->string('h1');
            $table->text('content');
            $table->integer('order');
            $table->timestamps();

            $table->foreign('timeline_page_id')->references('id')
                ->on('content_sheet_timeline_page')
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
        Schema::dropIfExists('content_sheet_timeline_line');
    }
}
