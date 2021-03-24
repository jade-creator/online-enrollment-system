<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendedSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attended_schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_graduated');
            $table->string('program')->nullable();
            $table->foreignId('school_type_id')->constrained();
            $table->foreignId('level_id')->constrained();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('attended_schools');
    }
}
