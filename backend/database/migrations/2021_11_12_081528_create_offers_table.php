<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('target')->nullable();
            $table->string('job')->nullable();
            $table->string('note')->nullable();
            $table->string('picture')->nullable();
            $table->string('link')->nullable();
            $table->date('post_date');
            $table->date('end_date');
            $table->unsignedBigInteger('student_number');
            $table->foreign('student_number')->references('student_number')->on('users')->cascadeOnDelete();
            $table->string('user_class');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
