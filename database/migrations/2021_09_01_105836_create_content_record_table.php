<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_record', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('content_record_category_id');
            $table->string('title')->nullable();
            $table->string('h1');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->boolean('is_published')->default('0');
            $table->timestamps();

            $table->foreign('content_record_category_id')->references('id')
                ->on('content_record_category')
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
        Schema::dropIfExists('content_record');
    }
}
