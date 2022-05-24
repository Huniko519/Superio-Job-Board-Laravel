<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bc_gigs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255)->nullable();
            $table->string('slug')->charset('utf8')->unique();
            $table->text('content')->nullable();
            $table->integer('image_id')->nullable();
            $table->integer('banner_image_id')->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table->string('gallery', 255)->nullable();
            $table->string('video_url', 255)->nullable();

            $table->bigInteger('cat_id')->nullable();
            $table->bigInteger('cat2_id')->nullable();
            $table->bigInteger('cat3_id')->nullable();

            //Price
            $table->decimal('basic_price', 12,2)->nullable();
            $table->decimal('standard_price', 12,2)->nullable();
            $table->decimal('premium_price', 12,2)->nullable();
            $table->text('extra_price')->nullable();
            $table->decimal('review_score',2,1)->nullable();
            $table->string('status',30)->nullable();

            $table->text('packages')->nullable();
            $table->text('package_compare')->nullable();
            $table->text('faqs')->nullable();
            $table->text('requirements')->nullable();
            $table->integer('basic_delivery_time')->nullable();


            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();

            $table->bigInteger('author_id')->nullable();

            $table->index(['status','cat2_id']);
            $table->index(['status','cat3_id']);
            $table->index(['status','author_id']);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bc_gig_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('origin_id')->unsigned();
            $table->string('locale')->index();
            $table->string('title', 255)->nullable();
            $table->text('content')->nullable();
            $table->text('packages')->nullable();
            $table->text('package_compare')->nullable();

            $table->text('faqs')->nullable();
            $table->text('requirements')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bc_gig_term', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('term_id')->nullable();
            $table->integer('target_id')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();
        });
        Schema::create('bc_gig_tags', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('tag_id')->nullable();
            $table->integer('target_id')->nullable();

            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->timestamps();
        });

        Schema::create('bc_gig_cat', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name',255)->nullable();
            $table->text('content')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('status',50)->nullable();
            $table->bigInteger('image_id')->nullable();
            $table->text('faqs')->nullable();
            $table->bigInteger('news_cat_id')->nullable();
            $table->nestedSet();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });
        Schema::create('bc_gig_cat_types', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name',255)->nullable();
            $table->text('content')->nullable();
            $table->string('slug')->nullable()->unique();
            $table->string('status',50)->nullable();
            $table->bigInteger('image_id')->nullable();
            $table->bigInteger('cat_id')->nullable();
            $table->text('cat_children')->nullable();
            $table->nestedSet();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });

        Schema::create('bc_gig_cat_trans', function (Blueprint $table) {
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

        Schema::create('bc_gig_cat_type_trans', function (Blueprint $table) {
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

        Schema::create('bc_gig_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('order_item_id')->nullable();
            $table->bigInteger('gig_id')->nullable();
            $table->bigInteger('author_id')->nullable();
            $table->bigInteger('customer_id')->nullable();

            $table->integer('revision')->nullable();
            $table->integer('delivery_time')->nullable();
            $table->timestamp('delivery_date')->nullable();
            $table->string('package', 30)->nullable()->default(0);

            $table->decimal('total',10,2)->nullable();// Subtotal, include extra price
            $table->decimal('price',10,2)->nullable();// Package price

            $table->text('extra_prices')->nullable();
            $table->text('requirements')->nullable();

            $table->string('status',30)->nullable();

            $table->text('meta')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('last_delivered')->nullable();

            $table->tinyInteger('is_on_time')->nullable()->default(0);
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->unique(['gig_id','order_item_id']);
            $table->index(['customer_id']);
            $table->index(['author_id']);

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bc_gig_order_activities', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('gig_order_id')->nullable()->index();
            $table->string('type',30)->nullable();
            $table->text('content')->nullable();
            $table->bigInteger('user_id')->nullable();

            $table->string('file_ids')->nullable();

            $table->text('meta')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *9*
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bc_gigs');
        Schema::dropIfExists('bc_gig_translations');
        Schema::dropIfExists('bc_gig_term');
        Schema::dropIfExists('bc_gig_tags');
        Schema::dropIfExists('bc_gig_cat');
        Schema::dropIfExists('bc_gig_cat_trans');
        Schema::dropIfExists('bc_gig_cat_types');
        Schema::dropIfExists('bc_gig_cat_type_trans');
        Schema::dropIfExists('bc_gig_orders');
        Schema::dropIfExists('bc_gig_order_activities');
    }
}
