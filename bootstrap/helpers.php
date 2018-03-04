<?php

if (!function_exists('get_switch_data')) {
    /**
     * 获取后台switch开关的配置数组
     *
     * @param array $config
     * @return array
     */
    function get_switch_data(array $config = [
        'open_text'  => '启用',
        'close_text' => '禁用',
    ]): array
    {
        return [
            'on'  => [
                'value' => 1,
                'text'  => $config['open_text'],
                'color' => 'primary',
            ],
            'off' => [
                'value' => 0,
                'text'  => $config['close_text'],
                'color' => 'default',
            ],
        ];
    }
}

if (!function_exists('admin_upload_link')) {
    /**
     * 获取后台上传图片完整链接
     *
     * @param string $url
     * @return string
     */
    function admin_upload_link(string $url): string
    {
        return config('filesystems.disks.admin.url') . '/' . $url;
    }
}

if (!function_exists('get_pay_type')) {
    /**
     * 获取支付方式
     *
     * @param $name
     * @return string
     */
    function get_pay_type(string $name): string
    {
        if (empty($name)) {
            return '';
        }

        $data = [
            'WECHAT_PAY'  => '微信支付',
            'BALANCE_PAY' => '余额支付',
            'ADMIN_PAY'   => '后台支付',
        ];

        return isset($data[$name]) ? $data[$name] : '';
    }
}

if (!function_exists('get_order_num')) {
    /**
     * 生成订单号
     *
     * @param $business_code
     * @return string
     */
    function get_order_num(string $business_code): string
    {
        return $business_code
            . date('YmdHi')
            . substr(microtime(), 2, 3)
            . sprintf('%02d', rand(0, 99));
    }
}