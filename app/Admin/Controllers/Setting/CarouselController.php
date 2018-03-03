<?php

namespace App\Admin\Controllers\Setting;

use App\Models\Carousel;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CarouselController extends Controller
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

            $content->header('首页轮播');


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

            $content->header('首页轮播');


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

            $content->header('首页轮播');


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
        return Admin::grid(Carousel::class, function (Grid $grid) {

            $grid->column('id')->sortable();

            $grid->column('image', __('field.image'))->image('', 40, 40);
            $grid->column('title', __('field.title'));
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
        return Admin::form(Carousel::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title', __('field.title'))->rules('required');
            $form->image('image', __('field.image'));
            $form->number('sort', __('field.sort'))->default(0)->help(__('help.sort'));
            $form->switch('status', __('field.status'))->states(get_switch_data())->value(1);

            $form->display('created_at', __('field.created_at'));
            $form->display('updated_at', __('field.updated_at'));
        });
    }
}
