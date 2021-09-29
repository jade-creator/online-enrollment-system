<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProspectusSubjectCorequisite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prospectus_subject_corequisite', function (Blueprint $table) {
            $table->foreignId('prospectus_subject_id')->constrained();
            $table->unsignedBigInteger('corequisite_id');
            $table->foreign('corequisite_id')->references('id')->on('subjects');
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
        Schema::dropIfExists('prospectus_subject_corequisite');
    }
}
