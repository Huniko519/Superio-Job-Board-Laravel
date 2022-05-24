<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateVer20 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('bc_jobs', function (Blueprint $table) {
            if (!Schema::hasColumn('bc_jobs', 'gallery')) {
                $table->string('gallery', 255)->nullable();
                $table->text('video')->nullable();
                $table->bigInteger('video_cover_id')->nullable();
            }
        });

        Schema::table('bc_job_candidates', function(Blueprint $table) {
            $table->bigInteger('company_id')->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
