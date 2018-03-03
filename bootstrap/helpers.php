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