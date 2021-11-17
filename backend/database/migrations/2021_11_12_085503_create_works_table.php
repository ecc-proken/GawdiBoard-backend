<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('works', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('short_description')->nullable();
            $table->string('note')->nullable();
            $table->string('picture')->nullable();
            $table->string('link')->nullable();
            $table->timestamp('post_date', $precision = 0);
            $table->unsignedBigInteger('student_number');
            $table->foreign('student_number')->references('student_number')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('works');
    }
}