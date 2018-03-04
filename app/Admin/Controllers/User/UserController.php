<?php

namespace App\Admin\Controllers\User;

use App\Models\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class UserController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('用户列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('用户');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('用户');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->column('id')->sortable();

            $grid->column('nickname', __('field.nickname'));
            $grid->column('avatar', __('field.avatar'))->image('', 40, 40);
            $grid->column('status', __('field.status'))->switch(get_switch_data());

            $grid->column('created_at', __('field.created_at'));
            $grid->column('updated_at', __('field.updated_at'));

            $grid->disableCreateButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('nickname', __('field.nickname'))->rules('required');
            $form->image('avatar', __('field.avatar'));
            $form->number('sort', __('field.sort'))->default(0)->help(__('help.sort'));
            $form->switch('status', __('field.status'))->states(get_switch_data())->value(1);

            $form->display('created_at', __('field.created_at'));
            $form->display('updated_at', __('field.updated_at'));
        });
    }
}
