<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEthicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ethics', function (Blueprint $table) {
            $table->id();
            $table->integer('partner_id');
            $table->boolean('active')->default(true);
            $table->integer('policy')->nullable();
            $table->integer('p1')->nullable();
            $table->integer('p2')->nullable();
            $table->integer('p3')->nullable();
            $table->integer('p4')->nullable();
            $table->integer('p5')->nullable();
            $table->boolean('person')->nullable();
            $table->text('person_detail')->nullable();
            $table->text('benefit_detail')->nullable();

            $table->boolean('q1')->nullable();
            $table->boolean('q2')->nullable();
            $table->boolean('q3')->nullable();
            $table->boolean('q4')->nullable();
            $table->boolean('q5')->nullable();
            $table->text('q_detail')->nullable();
            $table->text('r_detail')->nullable();
            $table->text('s_detail')->nullable();
            $table->boolean('t')->nullable();

            $table->string('p_name')->nullable();
            $table->string('p_des')->nullable();

            $table->string('policy_file')->nullable();
            $table->string('cert_file')->nullable();
            $table->string('statement_file')->nullable();
            $table->string('lexis_file')->nullable();

            $table->integer('pcountry')->unsigned()->nullable();
            $table->integer('pcpi')->unsigned()->nullable();
            $table->integer('phase')->unsigned()->nullable();
            
            $table->text('scope')->nullable();
            $table->string('contract')->nullable();

            $table->boolean('cdo')->nullable();
            $table->datetime('cdo_date')->nullable();
            $table->boolean('mutual')->nullable();
            $table->boolean('recomm')->nullable();
            $table->integer('search')->nullable();

            $table->string('screenshot_file')->nullable();
            $table->integer('satis')->nullable();
            $table->integer('practice')->nullable();
            $table->text('practice_detail')->nullable();
            $table->integer('need')->nullable();
            $table->text('flag')->nullable();
            $table->text('mitigation')->nullable();

            $table->integer('pm_by')->nullable();
            $table->datetime('pm_at')->nullable();
            $table->integer('ims_by')->nullable();
            $table->datetime('ims_at')->nullable();
            $table->integer('ims_assign')->nullable();

            $table->integer('ims_decision')->nullable();
            $table->text('ims_reason')->nullable();
            $table->text('ims_condition')->nullable();
            $table->text('ims_add')->nullable();

            $table->boolean('integrity')->nullable();
            $table->text('flag_action')->nullable();
            $table->integer('decision')->nullable();
            $table->text('reason')->nullable();
            $table->text('condition')->nullable();
            $table->text('add')->nullable();
            
            $table->integer('l1_by')->nullable();
            $table->datetime('l1_at')->nullable();
            $table->integer('l1_assign')->nullable();

            $table->integer('l1_decision')->nullable();
            $table->text('l1_reason')->nullable();
            $table->text('l1_condition')->nullable();
            $table->text('l1_add')->nullable();

            $table->integer('l2_by')->nullable();
            $table->datetime('l2_at')->nullable();
            $table->integer('l2_assign')->nullable();

            $table->integer('l2_decision')->nullable();
            $table->text('l2_reason')->nullable();
            $table->text('l2_condition')->nullable();
            $table->text('l2_add')->nullable();


            $table->SoftDeletes();
          
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
        Schema::dropIfExists('ethics');
    }
}
