<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWashTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wash_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('job_id')->nullable();
            $table->string('trx_number')->nullable();
            $table->text('item_detail')->nullable();
            $table->float('total')->nullable();
            $table->float('paid')->nullable();
            $table->float('change')->nullable();
            $table->integer('status')->nullable();
            $table->string('created_by')->nullable();
            $table->string('edited_by')->nullable();
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
        Schema::dropIfExists('wash_transactions');
    }
}
