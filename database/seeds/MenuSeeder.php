<?php

use Illuminate\Database\Seeder;


class MenuSeeder extends Seeder
{
    protected $menus = [
        [
            'title' => 'Index',
            'uri'   => '/',
        ],
        [
            'title'     => 'Admin',
            'uri'       => '',
            'sub_menus' => [
                ['title' => 'Users', 'uri' => 'auth/users',],
                ['title' => 'Roles', 'uri' => 'auth/roles',],
                ['title' => 'Permission', 'uri' => 'auth/permissions',],
                ['title' => 'Menu', 'uri' => 'auth/menu',],
                ['title' => 'Operation log', 'uri' => 'auth/logs',],
            ],
        ],
        [
            'title'     => '用户管理',
            'uri'       => '',
            'sub_menus' => [
                ['title' => '用户列表', 'uri' => 'users',],
                ['title' => '用户分组', 'uri' => 'userGroups',],
                ['title' => '用户等级', 'uri' => 'userLevels',],
            ],
        ],
        [
            'title'     => '网站设置',
            'uri'       => '',
            'sub_menus' => [
                ['title' => '广告列表', 'uri' => 'advertises',],
                ['title' => '首页轮播', 'uri' => 'carousels',],
                ['title' => '导航菜单', 'uri' => 'navMenus',],
            ],
        ],
        [
            'title'     => '商品管理',
            'uri'       => '',
            'sub_menus' => [
                ['title' => '商品列表', 'uri' => 'goods',],
                ['title' => '商品分类', 'uri' => 'good/categories',],
                ['title' => '商品主题', 'uri' => 'good/themes',],
            ],
        ],
    ];

    protected $helper_menus = [
        [
            'title'     => 'Helpers',
            'uri'       => '',
            'sub_menus' => [
                ['title' => 'Scaffold', 'uri' => 'helpers/scaffold',],
                ['title' => 'Database terminal', 'uri' => 'helpers/terminal/database',],
                ['title' => 'Laravel artisan', 'uri' => 'helpers/terminal/artisan',],
                ['title' => 'Routes', 'uri' => 'helpers/routes',],
            ],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu_table = config('admin.database.menu_table');

        // 先清空再填充菜单，便于开发阶段本地添加菜单后线上自动添加
        DB::table($menu_table)->truncate();

        $this->fill_menus();
    }

    private function fill_menus()
    {
        $menu_table = config('admin.database.menu_table');
        $menu_obj   = DB::table($menu_table);

        $menus = collect($this->menus);
        // 非生产环境添加工具菜单
        if (App::environment() !== 'production') {
            $menus = $menus->merge($this->helper_menus);
        }

        foreach ($menus as $menu) {
            $pid = $menu_obj->insertGetId([
                'parent_id' => 0,
                'title'     => $menu['title'],
                'order'     => 0,
                'icon'      => 'fa-tasks',
                'uri'       => $menu['uri'],
            ]);

            if (empty($menu['sub_menus'])) {
                continue;
            }

            $sub_menus = collect($menu['sub_menus'])->map(function ($item) use ($pid) {
                return collect($item)->merge([
                    'parent_id' => $pid,
                    'order'     => 0,
                    'icon'      => 'fa-tasks',
                ]);
            });

            $menu_obj->insert($sub_menus->toArray());
        }
    }
}
