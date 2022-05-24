<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTourAttrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bc_attrs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->string('service',50)->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();
        });

        Schema::create('bc_terms', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name',255)->nullable();
            $table->text('content')->nullable();
            $table->integer('attr_id')->nullable();
            $table->string('slug',255)->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();

            //Languages
            $table->bigInteger('origin_id')->nullable();
            $table->string('lang',10)->nullable();


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
        Schema::dropIfExists('bc_attrs');
        Schema::dropIfExists('bc_terms');
    }
}
