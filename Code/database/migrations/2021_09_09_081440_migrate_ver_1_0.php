<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateVer10 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_languages', function (Blueprint $table) {

            if (!Schema::hasColumn('core_languages', 'last_build_at')) {
                $table->timestamp('last_build_at')->nullable();
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('locale',10)->nullable();
        });

        Schema::table('core_news_category', function (Blueprint $table) {
            $table->bigInteger('origin_id')->nullable();
            $table->string('lang',10)->nullable();
        });
        $this->createTranslationTables();

        Schema::table('bc_review', function (Blueprint $table) {
            if (!Schema::hasColumn('bc_review', 'vendor_id')) {
                $table->bigInteger('vendor_id')->nullable();
            }
        });

        Schema::table('bc_terms', function (Blueprint $table) {
            if (!Schema::hasColumn('bc_terms', 'icon')) {
                $table->string('icon',50)->nullable();
            }
        });
        Schema::table('bc_attrs', function (Blueprint $table) {
            $table->softDeletes();
            if (!Schema::hasColumn('bc_attrs', 'hide_in_filter_search')) {
                $table->tinyInteger('hide_in_single')->nullable();
                $table->tinyInteger('hide_in_filter_search')->nullable();
            }
            if (!Schema::hasColumn('bc_attrs', 'position')) {
                $table->smallInteger('position')->nullable();
            }
        });
        Schema::table('bc_terms', function (Blueprint $table) {
            $table->softDeletes();
            $table->integer('image_id')->nullable();
        });


        Schema::table('bc_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bc_bookings', 'object_child_id')) {
                $table->bigInteger('object_child_id')->nullable();
            }
        });


        Schema::table('bc_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bc_bookings', 'number')) {
                $table->smallInteger('number')->nullable();
            }
        });
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'verify_submit_status')) {
                $table->string('verify_submit_status',30)->nullable();
            }
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->smallInteger('is_verified')->nullable();
            }
        });

        Schema::table('bc_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('paid', 'bc_bookings')) {
                $table->decimal('paid',10,2)->nullable();
            }
        });

        Schema::table('bc_bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('pay_now', 'bc_bookings')) {
                $table->decimal('pay_now',10,2)->nullable();
            }
        });

        Schema::table('bc_candidates', function (Blueprint $table) {
            if (!Schema::hasColumn('bc_candidates', 'video_cover_id')) {
                $table->bigInteger('video_cover_id')->nullable();
            }
        });

        Schema::table('bc_jobs', function (Blueprint $table) {
            if (!Schema::hasColumn('bc_jobs', 'apply_type')) {
                $table->string('apply_type', 20)->nullable();
                $table->text('apply_link')->nullable();
                $table->text('apply_email')->nullable();
            }
        });
    }

    public function createTranslationTables(){

        Schema::create('core_page_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title',255)->nullable();
            $table->text('content')->nullable();
            $table->text('short_desc')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();

            $table->unique(['origin_id', 'locale']);

            $table->timestamps();
        });

        Schema::create('core_news_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title',255)->nullable();
            $table->text('content')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
        });

        Schema::create('core_news_category_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_id')->unsigned();
            $table->string('locale')->index();

            $table->string('name',255)->nullable();
            $table->text('content')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
        });

        Schema::create('core_tag_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_id')->unsigned();
            $table->string('locale')->index();

            $table->string('name',255)->nullable();
            $table->text('content')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
        });

        Schema::create('core_menu_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_id')->unsigned();
            $table->string('locale')->index();

            $table->longText('items')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
        });
        Schema::create('core_template_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title',255)->nullable();
            $table->longText('content')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
        });

        Schema::create('bc_location_translations', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('origin_id')->nullable();
            $table->string('locale',10)->nullable();

            $table->string('name',255)->nullable();
            $table->text('content')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->unique(['origin_id', 'locale']);
            $table->timestamps();
        });

        Schema::create('bc_attrs_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale',10)->nullable();

            $table->string('name',255)->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->unique(['origin_id', 'locale']);
            $table->timestamps();
        });

        Schema::create('bc_terms_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('origin_id')->nullable();
            $table->string('locale',10)->nullable();

            $table->string('name',255)->nullable();
            $table->text('content')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->unique(['origin_id', 'locale']);
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
        Schema::dropIfExists('core_page_translations');
        Schema::dropIfExists('core_news_translations');
        Schema::dropIfExists('core_news_category_translations');
        Schema::dropIfExists('core_tag_translations');
        Schema::dropIfExists('core_menu_translations');
        Schema::dropIfExists('core_template_translations');
        Schema::dropIfExists('bc_location_translations');
        Schema::dropIfExists('bc_attrs_translations');
        Schema::dropIfExists('bc_terms_translations');
    }
}
