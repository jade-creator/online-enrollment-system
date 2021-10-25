<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectusSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospectus_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prospectus_id')->constrained();
            $table->foreignId('subject_id')->constrained();
            $table->integer('unit');
            $table->boolean('isComputed')->default(1);
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
        Schema::dropIfExists('prospectus_subjects');
    }
}
