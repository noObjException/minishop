<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export (1.4.1)
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255)->default('');
            $table->decimal('price', 10, 2)->default(0.00);
            $table->unsignedInteger('category_id')->default(0);
            $table->unsignedInteger('theme_id')->default(0);
            $table->json('thumbs')->nullable();
            $table->text('detail')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedInteger('sort')->default(0);
            $table->string('description', 255)->default('');
            $table->softDeletes();
            $table->nullableTimestamps();
            $table->unsignedInteger('stock')->default(0)->comment('库存');

            

            

        });

        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods');
    }
}
