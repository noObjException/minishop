<?php

namespace App\Admin\Controllers\Setting;

use App\Models\Setting;

use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Support\MessageBag;

class WechatMiniProgramController extends Controller
{
    use ModelForm;

    public function index()
    {
        // 直接跳转到对应的配置项
        $id = Setting::firstOrCreate(['name' => 'WECHAT_MINI_PROGRAM'])->id;

        return redirect()->action(
            '\\' . config('admin.route.namespace') . '\Setting\WechatMiniProgramController@edit', ['id' => $id]
        );
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('微信小程序设置');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Setting::class, function (Form $form) {
            // 转成json格式保存
            $form->embeds('content', '', function ($form) {
                $form->text('app_id')->rules('required');
                $form->text('app_secret')->rules('required');
                $form->text('token');
                $form->text('aes_key');

                $form->text('merchant_id', '商户id');
                $form->text('pay_api_key', '商户key');
            });

            $form->display('updated_at', '修改时间');

            $form->saved(function () {
                $success = new MessageBag([
                    'title'   => '修改成功',
                    'message' => '',
                ]);

                return back()->with(compact('success'));
            });

            $form->disableReset();
            $form->tools(function (Form\Tools $tools) {
                // 去掉返回按钮
                $tools->disableBackButton();
                // 去掉跳转列表按钮
                $tools->disableListButton();
            });
        });
    }
}
