<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained();
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('prospectus_subjects');
            $table->foreignId('mark_id')->constrained();
            $table->boolean('isScale')->default(0);
            $table->unsignedDecimal('value', '3', '2')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
