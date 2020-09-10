<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArrangementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arrangements', function (Blueprint $table) {
            $table->id();
           
            $table->integer('partner_id');

            $table->text('scope')->nullable();
            $table->string('contract')->nullable();
            $table->integer('pcountry')->unsigned()->nullable();
            $table->integer('pcpi')->unsigned()->nullable();
            $table->integer('phase')->unsigned()->nullable();



            $table->boolean('cdo')->nullable();
            $table->datetime('cdo_date')->nullable();
            $table->boolean('mutual')->nullable();
            $table->boolean('recomm')->nullable();

            $table->text('remarks')->nullable();

            $table->integer('user_id')->unsigned();
            $table->softDeletes('deleted_at');

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
        Schema::dropIfExists('arrangements');
    }
}




