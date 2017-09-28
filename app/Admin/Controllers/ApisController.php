<?php

namespace App\Admin\Controllers;

use App\Models\Api;

use App\Models\ApiGroup;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class ApisController extends Controller
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

            $content->header('APIs');

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

            $content->header('APIs');

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

            $content->header('APIs');

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
        return Admin::grid(Api::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->name();
            $grid->group()->name('Group');
            $grid->method();
            $grid->timeout();
            $grid->except_status();
            $grid->fakers()->count();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();
                $filter->equal('group_id', 'Group')->select(
                    ApiGroup::all()->pluck('name', 'id')
                );
                $filter->equal('method')->select([
                    'POST' => 'POST',
                    'GET' => 'GET',
                ]);
            });

            $grid->disableExport();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Api::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('group_id', 'Group')->options(
                ApiGroup::all()->pluck('name', 'id')
            )->rules('required|exists:api_groups,id');
            $form->url('url')->rules('required|url');
            $form->text('name')->rules('required|string');
            $form->select('method')->options([
                'GET' => 'GET',
                'POST' => 'POST',
                'PUT' => 'PUT',
                'PATCH' => 'PATCH',
            ])->rules('required|in:GET,POST,PUT,PATCH');
            $form->switch('is_json_body', 'Is Json Body')->states([
                'on' => [
                    'value' => 'yes',
                ],
                'off' => [
                    'value' => 'no',
                ],
            ])->default('no');
            $form->number('timeout')->default('5')->rules('required|integer|min:3');
            $form->number('except_status')->default(200)->rules('required|integer|min:200|max:599');
            $form->json('headers', 'Request Headers')->default('{}')->rule('required|json');
            $form->json('options', 'Request Options')->default('{}')->rule('required|json');
            $form->json('rules', 'Validate Rules')->default('{}')->rule('required|json');
        });
    }
}
