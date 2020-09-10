<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFinanceApproval extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ethics', function (Blueprint $table) {
            $table->integer('finance_assigned')->unsigned()->nullable();
            $table->text('finance_remarks')->nullable();
            $table->integer('finance_approved_by')->unsigned()->nullable();
            $table->dateTime('finance_approved_on')->unsigned()->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
