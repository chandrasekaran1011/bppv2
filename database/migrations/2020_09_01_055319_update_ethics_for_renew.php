<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEthicsForRenew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ethics', function (Blueprint $table) {


            $table->integer('renew_pm_by')->nullable();
            $table->datetime('renew_pm_at')->nullable();
            $table->integer('renew_ims_by')->nullable();
            $table->datetime('renew_ims_at')->nullable();

            $table->integer('renew_pcountry')->unsigned()->nullable();
            $table->integer('renew_pcpi')->unsigned()->nullable();
            $table->integer('renew_phase')->unsigned()->nullable();
        
            $table->text('renew_scope')->nullable();
            $table->string('renew_contract')->nullable();

            $table->boolean('renew_cdo')->nullable();
            $table->datetime('renew_cdo_date')->nullable();
            $table->boolean('renew_mutual')->nullable();
            $table->boolean('renew_recomm')->nullable();
            $table->integer('renew_search')->nullable();

            $table->text('renew_flag')->nullable();
            $table->text('renew_mitigation')->nullable();
            $table->text('renew_flag_action')->nullable();

            $table->integer('renew_ims_decision')->nullable();
            $table->text('renew_ims_reason')->nullable();
            $table->text('renew_ims_condition')->nullable();
            $table->text('renew_ims_add')->nullable();
            $table->boolean('renew_integrity')->nullable();
            $table->boolean('renew_breach')->nullable();
            $table->string('renew_screenshot_file')->nullable();
            $table->string('renew_lexis_file')->nullable();
            $table->string('need_file')->nullable();
                    
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
            $table->dropColumn(['renew_pm_by','renew_pm_by']);
        });
    }
}
