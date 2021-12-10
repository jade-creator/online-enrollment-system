<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained();
            $table->string('custom_id', 100);
            $table->string('name', 100)->nullable()->default(null);
            $table->string('email', 100)->nullable()->default(null);
            $table->string('status', 100)->nullable()->default(NULL);
            $table->bigInteger('amount');
            $table->bigInteger('running_balance');
            $table->timestamp('archived_at')->nullable()->default(NULL);
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
        Schema::dropIfExists('transactions');
    }
}
