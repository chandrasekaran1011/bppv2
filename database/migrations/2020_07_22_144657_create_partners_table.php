<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('reg')->nullable()->unique();
            $table->integer('rno')->nullable()->unsigned();
            $table->string('name');
            $table->text('address')->nullable();
            $table->integer('type_id')->unsigned();
            $table->integer('country_id')->unsigned();
            $table->integer('cpi')->unsigned();
            $table->string('email')->nullable();
            $table->integer('project_id')->unsigned();
            $table->integer('status')->unsigned();
            
            $table->text('tp')->nullable();
            $table->text('license')->nullable();

            $table->text('cop_num')->nullable();
            $table->text('cop_juri')->nullable();
            $table->datetime('doi')->nullable();
            $table->boolean('stock')->default(false);
            $table->text('stock_name')->nullable();
            $table->text('stock_detail')->nullable();
            $table->text('director')->nullable();
            $table->text('subsidiary')->nullable();
            $table->integer('employee')->unsigned()->nullable();
            $table->boolean('revenue')->default(false);
            $table->boolean('insolvency')->default(false);


            $table->datetime('approved_on')->nullable();
            $table->datetime('due_on')->nullable();

            $table->integer('cuser')->unsigned();
            $table->integer('approved_by')->unsigned()->nullable();

            $table->integer('blacklist_by')->unsigned()->nullable();
            $table->datetime('blacklist_on')->nullable();
            $table->text('blacklist_reason')->nullable();
            $table->text('blacklist_remarks')->nullable();
            $table->datetime('blacklist_till')->nullable();

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
        Schema::dropIfExists('partners');
    }
}
