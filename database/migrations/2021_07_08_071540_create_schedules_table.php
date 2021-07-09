<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained();
            $table->time('start_time_monday')->nullable();
            $table->time('end_time_monday')->nullable();
            $table->time('start_time_tuesday')->nullable();
            $table->time('end_time_tuesday')->nullable();
            $table->time('start_time_wednesday')->nullable();
            $table->time('end_time_wednesday')->nullable();
            $table->time('start_time_thursday')->nullable();
            $table->time('end_time_thursday')->nullable();
            $table->time('start_time_friday')->nullable();
            $table->time('end_time_friday')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
