<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained();
            $table->bigInteger('additional')->default(0);
            $table->boolean('isPercentage')->nullable();
            $table->bigInteger('discount_amount')->default(0);
            $table->bigInteger('grand_total')->default(0);
            $table->bigInteger('balance')->default(0);
            $table->text('remarks')->nullable();
            $table->boolean('isUnifastBeneficiary')->default(0);
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
        Schema::dropIfExists('assessments');
    }
}
