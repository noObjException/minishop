<?php

namespace App\Admin\Controllers\Good;

use App\Models\Good;

use App\Models\GoodCategory;
use App\Models\GoodTheme;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class GoodController extends Controller
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

            $content->header('商品');


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

            $content->header('商品');


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

            $content->header('商品');


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
        return Admin::grid(Good::class, function (Grid $grid) {

            $grid->column('id')->sortable();

            $grid->column('thumbs', __('field.image'))->display(function ($thumbs) {
                return $thumbs[0];
            })->image('', 40, 40);
            $grid->column('title', __('field.title'));
            $grid->column('category.title', __('field.category'));
            $grid->column('theme.title', __('field.theme'));
            $grid->column('price', __('field.price'))->display(function ($price) {
                return '¥ ' . $price;
            });
            $grid->column('status', __('field.status'))->switch(get_switch_data());

            $grid->column('created_at', __('field.created_at'));
            $grid->column('updated_at', __('field.updated_at'));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Good::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title', __('field.title'))->rules('required');
            $form->select('category_id', __('field.category'))->options(collect(GoodCategory::selectOptions())->slice(1)->all());
            $form->select('theme_id', __('field.theme'))->options(collect(GoodTheme::selectOptions())->slice(1)->all());
            $form->textarea('description', __('field.description'));
            $form->multipleImage('thumbs', __('field.image'));
            $form->currency('price', __('field.price'))->symbol('￥');
            $form->editor('detail', __('field.detail'));
            $form->number('sort', __('field.sort'))->default(0)->help(__('help.sort'));
            $form->switch('status', __('field.status'))->states(get_switch_data())->value(1);

            $form->display('created_at', __('field.created_at'));
            $form->display('updated_at', __('field.updated_at'));
        });
    }
}
