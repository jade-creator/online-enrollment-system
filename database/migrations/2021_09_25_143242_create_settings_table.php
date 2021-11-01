<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('profile_photo_path')->nullable()->default(NULL);
            $table->string('school_name', 100)->nullable()->default(NULL);
            $table->string('school_email', 100)->nullable()->default(NULL);
            $table->text('school_address')->nullable()->default(NULL);
            $table->text('school_description')->nullable()->default(NULL);
            $table->boolean('auto_account_approval')->default(1);
            $table->boolean('allow_irregular_student_to_enroll')->default(1);
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
        Schema::dropIfExists('settings');
    }
}
