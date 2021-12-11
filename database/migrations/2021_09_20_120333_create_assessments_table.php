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
            $table->unsignedBigInteger('additional')->default(0);
            $table->boolean('isPercentage')->nullable();
            $table->unsignedSmallInteger('discount_amount')->default(0);
            $table->unsignedBigInteger('grand_total')->default(0);
            $table->unsignedBigInteger('balance')->default(0);
            $table->unsignedBigInteger('downpayment')->default(0);
            $table->unsignedBigInteger('amount_due')->default(0);
            $table->text('remarks')->nullable();
            $table->boolean('isUnifastBeneficiary')->default(0);
            $table->boolean('isFullPayment')->nullable()->default(0);
            $table->date('first_due_date')->nullable();
            $table->date('second_due_date')->nullable();
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
