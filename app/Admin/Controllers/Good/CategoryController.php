<?php

namespace App\Admin\Controllers\Good;

use App\Models\GoodCategory;

use Encore\Admin\Form;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;

class CategoryController extends Controller
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

            $content->header('商品分类');

            $content->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_base_path('good/categories'));

                    $form->number('sort', __('field.sort'));
                    $form->select('pid', __('field.parent'))->options(GoodCategory::selectOptions());
                    $form->text('title', __('field.title'))->rules('required');
                    $form->image('image', __('field.image'));
                    $form->switch('status', __('field.status'))->states(get_switch_data())->value(1);
                    $form->hidden('_token')->default(csrf_token());

                    $column->append((new Box(__('admin.new'), $form))->style('success'));
                });
            });
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

            $content->header('商品分类');


            $content->body($this->form()->edit($id));
        });
    }

    private function treeView()
    {
        return GoodCategory::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $payload = '&nbsp;<img src=' . admin_upload_link($branch['image']) . ' width="30"/>&nbsp;&nbsp;';
                $payload .= "&nbsp;&nbsp;<strong>{$branch['title']}</strong>";

                return $payload;
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(GoodCategory::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->number('sort', __('field.sort'))->default(0)->help(__('help.sort'));
            $form->select('pid', __('field.parent'))->options(GoodCategory::selectOptions());
            $form->text('title', __('field.title'))->rules('required');
            $form->image('image', __('field.image'));
            $form->switch('status', __('field.status'))->states(get_switch_data())->value(1);

            $form->display('created_at', __('field.created_at'));
            $form->display('updated_at', __('field.updated_at'));
        });
    }
}
