<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();  // 解除模型批量填充限制

        // $this->call(UsersTableSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(MenuSeeder::class);

        Model::reguard();  // 恢复模型批量填充限制
    }
}
