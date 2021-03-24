<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {
            $table->id();
            $table->enum('gender',['Other', 'Male', 'Female', 'Prefer not to say']);
            $table->enum('civil_status',['Single', 'Married', 'Divorced', 'Widowed', 'Prefer not to say']);
            $table->enum('religion',['Other', 'Catholic Christianity', 'Protestant Christianity', 'Islam', 'Tribal', 'None']);
            $table->date('birthdate');
            $table->string('birthplace');
            $table->foreignId('person_id')->constrained();
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
        Schema::dropIfExists('details');
    }
}
