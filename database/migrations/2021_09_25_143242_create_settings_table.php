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
            $table->text('profile_photo_path')->nullable();
            $table->string('school_name', 100)->nullable();
            $table->string('school_email', 100)->nullable();
            $table->text('school_address')->nullable();
            $table->text('school_description')->nullable();
            $table->boolean('auto_account_approval')->default(1);
            $table->boolean('allow_irregular_student_to_enroll')->default(1);
            $table->smallInteger('downpayment_minimum_percentage')->default(0);
            $table->smallInteger('penalty_percentage')->default(0);
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
