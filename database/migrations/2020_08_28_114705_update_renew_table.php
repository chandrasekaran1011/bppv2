<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRenewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renews', function (Blueprint $table) {
           $table->integer('pcountry')->unsigned()->nullable();
            $table->integer('pcpi')->unsigned()->nullable();
           $table->integer('phase')->unsigned()->nullable();
            
           $table->text('scope')->nullable();
           $table->string('contract')->nullable();

           $table->boolean('cdo')->nullable();
           $table->datetime('cdo_date')->nullable();
           $table->boolean('mutual')->nullable();
           $table->boolean('recomm')->nullable();

            //$table->integer('decision')->nullable();
            $table->integer('pm_by')->nullable();
            $table->dateTime('pm_on')->nullable();
            $table->integer('ims_by')->nullable();
            $table->dateTime('ims_on')->nullable();
            $table->text('mitigation')->nullable();
            $table->string('screenshot_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('renews', function (Blueprint $table) {
            $table->dropColumn(['decision','ims_by','ims_on','mitigation','screenshot_file']);
        });
    }
}
