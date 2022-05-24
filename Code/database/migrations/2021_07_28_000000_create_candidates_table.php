<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bc_candidates', function (Blueprint $table) {
            $table->id();

            $table->string('title',255)->nullable();
            $table->string('website',255)->nullable();
            $table->string('gender',255)->nullable();
            $table->string('gallery', 255)->nullable();
            $table->string('video', 255)->nullable();
            $table->string('allow_search',255)->nullable();
            $table->text('education')->nullable();
            $table->text('experience')->nullable();
            $table->text('award')->nullable();
            $table->text('social_media')->nullable();
            $table->string('languages',255)->nullable();
            $table->string('education_level',255)->nullable();
            $table->integer('experience_year')->nullable();
            $table->string('expected_salary', 255)->nullable();
            $table->string('salary_type', 255)->nullable();

            $table->bigInteger('location_id')->nullable();
            $table->string('map_lat', 30)->nullable();
            $table->string('map_lng', 30)->nullable();
            $table->integer('map_zoom')->nullable();
            $table->string('city',255)->nullable();
            $table->string('country',255)->nullable();
            $table->string('address',255)->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->string('slug', 255)->charset('utf8')->index();

            $table->softDeletes();

            //Languages
            $table->bigInteger('origin_id')->nullable();
            $table->string('lang',10)->nullable();

            $table->timestamps();
        });

        Schema::create('bc_candidate_translation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title',255)->nullable();
            $table->text('bio')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
        });

        Schema::create('bc_candidate_cvs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('file_id')->nullable();
            $table->integer('origin_id')->unsigned();
            $table->tinyInteger('is_default')->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
        });

        Schema::create('bc_candidate_skills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('origin_id');
            $table->unsignedBigInteger('skill_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('bc_candidate_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('origin_id');
            $table->unsignedBigInteger('cat_id')->unsigned();
            $table->timestamps();
        });

        Schema::create('bc_candidate_contact', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->text('message')->nullable();
            $table->string('status', 50)->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
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
        Schema::dropIfExists('bc_candidates');
        Schema::dropIfExists('bc_candidate_translation');
        Schema::dropIfExists('bc_candidate_cvs');
        Schema::dropIfExists('bc_candidate_skills');
        Schema::dropIfExists('bc_candidate_categories');
        Schema::dropIfExists('bc_candidate_contact');
    }
}
