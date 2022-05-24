<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bc_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255)->nullable();
            $table->string('email',255)->nullable();
            $table->string('phone',30)->nullable();
            $table->string('website',255)->nullable();
            $table->bigInteger('avatar_id')->nullable();
            $table->bigInteger('cover_id')->nullable();
            $table->date('founded_in')->nullable();
            $table->tinyInteger('allow_search')->nullable()->default(0);
            $table->tinyInteger('is_featured')->nullable()->default(0);
            $table->bigInteger('owner_id')->nullable();
            $table->bigInteger('location_id')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->integer('team_size')->default(0);
            $table->text('about')->nullable();
            $table->text('social_media')->nullable();
            $table->string('city',255)->nullable();
            $table->string('state',255)->nullable();
            $table->string('country',255)->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('address',255)->nullable();
            $table->string('slug',255)->charset('utf8')->index()->nullable();
            $table->string('status',20)->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->string('map_lat',30)->nullable();
            $table->string('map_lng',30)->nullable();
            $table->softDeletes();

            $table->timestamps();
        });
        Schema::create('bc_company_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name',255)->nullable();
            $table->text('about')->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
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
        Schema::dropIfExists('bc_companies');
        Schema::dropIfExists('bc_company_translations');
    }
}
