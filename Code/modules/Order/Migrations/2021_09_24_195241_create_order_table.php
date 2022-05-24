<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bc_orders', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('customer_id')->nullable();

            $table->decimal('subtotal',10,2)->nullable();
            $table->decimal('total',10,2)->nullable();
            $table->bigInteger('payment_id')->nullable();
            $table->string('gateway',50)->nullable();
            $table->string('status',30)->nullable();
            $table->decimal('paid',10,2)->nullable();

            $table->text('billing')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bc_order_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('order_id')->nullable();
            $table->bigInteger('object_id')->nullable();
            $table->string('object_model',255)->nullable();

            $table->decimal('price',10,2)->nullable();
            $table->integer('qty')->default(1)->nullable();
            $table->decimal('subtotal',10,2)->nullable();

            $table->string('status',30)->nullable();

            $table->text('meta')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('bc_order_meta', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('order_id')->nullable();
            $table->string('name',255)->nullable();
            $table->text('val')->nullable();


            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();

            $table->timestamps();
        });

        Schema::create('bc_payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('object_id')->nullable();
            $table->string('object_model',30)->nullable();

            $table->string('gateway',50)->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->string('currency',10)->nullable();

            $table->decimal('converted_amount',10,2)->nullable();
            $table->string('converted_currency',10)->nullable();
            $table->decimal('exchange_rate',10,2)->nullable();

            $table->string('status',30)->nullable();
            $table->text('logs')->nullable();

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });

        Schema::create('bc_payment_meta', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('payment_id')->nullable();
            $table->string('name',255)->nullable();
            $table->text('val')->nullable();


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
        Schema::dropIfExists('bc_orders');
        Schema::dropIfExists('bc_order_items');
        Schema::dropIfExists('bc_order_meta');
        Schema::dropIfExists('bc_payments');
        Schema::dropIfExists('bc_payment_meta');
    }
}
