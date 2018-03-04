<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('用户id');
            $table->string('order_num')->default('')->comment('订单号');
            $table->decimal('price')->default('0.00')->comment('价格');
            $table->tinyInteger('status')->index()->comment('状态');
            $table->string('pay_type')->default('')->comment('支付方式');
            $table->string('remark')->default('')->comment('备注');
            $table->json('address')->comment('地址');
            $table->timestamp('finished_at')->default(null)->comment('完成时间')->nullable();
            $table->timestamp('paid_at')->default(null)->comment('付款时间时间')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
