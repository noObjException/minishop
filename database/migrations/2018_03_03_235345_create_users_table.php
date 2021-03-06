<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'users';

    /**
     * Run the migrations.
     * @table users
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('username', 50)->default('');
            $table->string('nickname', 50)->default('');
            $table->string('realname', 50)->default('');
            $table->string('email')->default('');
            $table->tinyInteger('status')->default('0');
            $table->unsignedInteger('group_id')->default('0');
            $table->unsignedInteger('level_id')->default('0');
            $table->string('password')->default('');
            $table->string('wx_official_account_openid', 45)->default('')->comment('微信公众号openid');
            $table->string('wx_mini_program_openid', 45)->default('')->comment('微信小程序openid');
            $table->string('wx_union_id', 45)->default('')->comment('微信unionid，微信公众号id与微信小程序关联的id');
            $table->string('phone', 20)->default('')->comment('用户手机号');
            $table->integer('point')->default('0')->comment('用户积分');
            $table->decimal('balance', 10, 2)->default('0.00')->comment('用户余额');
            $table->tinyInteger('gender')->default('0')->comment('性别：0未知，1男，2女');
            $table->string('avatar')->default('')->comment('头像');
            $table->string('province', 45)->default('');
            $table->string('city', 45)->default('');
            $table->string('area', 45)->default('');
            $table->string('register_ip', 20)->default('0.0.0.0')->comment('注册ip');
            $table->string('last_login_ip', 20)->default('0.0.0.0')->comment('最后登录ip');
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
