<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('status_id')->default(1)->constrained();
            $table->foreignId('section_id')->nullable()->constrained();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('prospectus_id')->constrained();
            $table->boolean('isRegular')->default(1);
            $table->boolean('isNew')->default(0);
            $table->boolean('isExtension')->default(0);
            $table->timestamp('released_at')->nullable();
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
        Schema::dropIfExists('registrations');
    }
}
