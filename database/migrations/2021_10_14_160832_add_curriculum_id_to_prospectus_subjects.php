<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurriculumIdToProspectusSubjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prospectus_subjects', function (Blueprint $table) {
            $table->foreignId('curriculum_id')->nullable()->default(null)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prospectus_subjects', function (Blueprint $table) {
            $table->dropForeign('prospectus_subjects_curriculum_id_foreign');
            $table->dropColumn('curriculum_id');
        });
    }
}
