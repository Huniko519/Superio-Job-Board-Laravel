<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBcJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bc_jobs', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->string('slug', 255)->charset('utf8')->index();
            $table->text('content')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('thumbnail_id')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('job_type_id')->nullable();
            $table->dateTime('expiration_date')->nullable();
            $table->string('hours')->nullable();
            $table->string('hours_type')->nullable();
            $table->string('salary_type')->nullable();
            $table->decimal('salary_min',15)->nullable();
            $table->decimal('salary_max',15)->nullable();
            $table->string('gender', 30)->nullable();
            $table->string('map_lat', 30)->nullable();
            $table->string('map_lng', 30)->nullable();
            $table->integer('map_zoom')->nullable();
            $table->float('experience')->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->tinyInteger('is_urgent')->nullable();
            $table->string('status', 30)->nullable();
            $table->softDeletes();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamps();
        });

        Schema::create('bc_job_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('origin_id');
            $table->string('locale', 100)->nullable();
            $table->text('title')->nullable();
            $table->text('content')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();
        });

        Schema::create('bc_job_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();;
            $table->text('slug')->nullable();
            $table->string('status')->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bc_job_type_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale',10)->nullable();

            $table->string('name',255)->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->unique(['origin_id', 'locale']);
            $table->timestamps();
        });

        Schema::create('bc_job_candidates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('job_id');
            $table->bigInteger('candidate_id');
            $table->bigInteger('cv_id');
            $table->text('message');
            $table->text('status');
            $table->bigInteger('company_id');
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
        });

        Schema::create('bc_job_skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('skill_id')->unsigned();
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
        Schema::dropIfExists('bc_jobs');
        Schema::dropIfExists('bc_job_translations');
        Schema::dropIfExists('bc_job_types');
        Schema::dropIfExists('bc_job_type_translations');
        Schema::dropIfExists('bc_job_candidates');
        Schema::dropIfExists('bc_job_skills');
    }
}
