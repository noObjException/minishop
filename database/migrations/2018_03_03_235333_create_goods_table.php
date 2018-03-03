<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'goods';

    /**
     * Run the migrations.
     * @table goods
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title')->default('');
            $table->decimal('price', 10, 2)->default('0.00');
            $table->unsignedInteger('category_id')->default('0');
            $table->unsignedInteger('theme_id')->default('0');
            $table->json('thumbs')->nullable()->default(null);
            $table->text('detail')->nullable()->default(null);
            $table->tinyInteger('status')->default('0');
            $table->unsignedInteger('sort')->default('0');
            $table->string('description')->default('');
            $table->unsignedInteger('stock')->default('0')->comment('库存');
            $table->softDeletes();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
