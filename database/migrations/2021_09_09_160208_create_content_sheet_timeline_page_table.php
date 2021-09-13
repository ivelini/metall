<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentSheetTimelinePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_sheet_timeline_page', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('h1');
            $table->string('slug');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_published')->default('0');
            $table->timestamps();

            $table->foreign('company_id')->references('id')
                ->on('company')
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
        Schema::dropIfExists('content_sheet_timeline_page');
    }
}
