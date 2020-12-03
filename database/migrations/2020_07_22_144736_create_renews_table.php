<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renews', function (Blueprint $table) {
            $table->id();
            $table->integer('partner_id');
            $table->boolean('initial')->default(false);
            $table->boolean('integrity');
            $table->boolean('breach')->nullable();      
            $table->text('flag_action')->nullable();
            $table->integer('decision')->default(1);
            $table->text('condition')->nullable();
            $table->text('reason')->nullable();
            $table->text('add')->nullable(); 
            $table->integer('user_id');
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
        Schema::dropIfExists('renews');
    }
}
