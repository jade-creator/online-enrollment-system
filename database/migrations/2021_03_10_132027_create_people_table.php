<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('suffix')->nullable();
            $table->enum('gender',['Other', 'Male', 'Female', 'Prefer not to say'])->nullable();
            $table->enum('civil_status',['Single', 'Married', 'Divorced', 'Widowed', 'Prefer not to say'])->nullable();
            $table->enum('religion',['Other', 'Catholic Christianity', 'Protestant Christianity', 'Islam', 'Tribal', 'None'])->nullable();
            $table->string('nationality')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birthplace')->nullable();
            $table->timestamps();
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
