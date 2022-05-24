<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBcSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bc_skills', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->string('status',50)->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bc_skill_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale',10)->nullable();
            $table->string('name',255)->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->unique(['origin_id', 'locale']);
            $table->softDeletes();
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
        Schema::dropIfExists('bc_skills');
        Schema::dropIfExists('bc_skill_translations');
    }
}
