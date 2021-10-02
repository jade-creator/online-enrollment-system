<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advice', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->nullable()->constrained();
            $table->foreignId('level_id')->nullable()->constrained();
            $table->string('date', 100);
            $table->string('time', 100);
            $table->string('link', 100);
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('advice');
    }
}
