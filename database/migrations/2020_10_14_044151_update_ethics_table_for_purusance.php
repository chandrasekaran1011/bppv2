<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEthicsTableForPurusance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ethics', function (Blueprint $table) {
            $table->integer('head_assign')->unsigned()->nullable();
            $table->integer('head_by')->nullable();
            $table->datetime('head_at')->nullable();
            $table->integer('head_decision')->nullable();
            $table->text('head_reason')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ethics', function (Blueprint $table) {
            $table->dropColumn(['head_assign','head_by','head_at','head_decision','head_reason']);
        });
    }
}
