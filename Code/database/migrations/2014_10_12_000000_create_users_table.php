<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('first_name',255)->nullable();
            $table->string('last_name',255)->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone',30)->nullable();
            $table->date('birthday')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->bigInteger('avatar_id')->nullable();
            $table->text('bio')->nullable();
            $table->string('status',20)->nullable();
            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->integer('vendor_commission_amount')->nullable();
            $table->string('vendor_commission_type',30)->nullable();

            $table->bigInteger('role_id')->nullable();

            $table->string('billing_last_name')->nullable();
            $table->string('billing_first_name')->nullable();
            $table->string('country',30)->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('address')->nullable();
            $table->string('address2')->nullable();

            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('user_wishlist', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('object_id')->nullable();
            $table->string('object_model', 255)->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_wishlist');
    }
}
