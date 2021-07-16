<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registration_subject', function (Blueprint $table) {
            $table->foreignId('registration_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->unsignedInteger('grade')->nullable();
            $table->foreignId('mark_id')->constrained();
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
        Schema::dropIfExists('registration_subject');
    }
}
