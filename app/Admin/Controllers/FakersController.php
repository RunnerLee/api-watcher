<?php

namespace App\Admin\Controllers;

use App\Models\Api;
use App\Models\ApiGroup;
use App\Models\Faker;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class FakersController extends Controller
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

            $content->header('Fakers');

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

            $content->header('Fakers');

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

            $content->header('Fakers');

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
        return Admin::grid(Faker::class, function (Grid $grid) {

            $grid->model()->load('api.group');

            $grid->id('ID')->sortable();
            $grid->api()->group_id('Group')->value(function ($value) {
                return ApiGroup::find($value)->name;
            });
            $grid->api()->name('API');
            $grid->created_at();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();
                $filter->equal('api_id', 'Api')->select(
                    Api::all()->pluck('name', 'id')
                );
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
        return Admin::form(Faker::class, function (Form $form) {

            $form->display('id', 'ID');

            $form
                ->select('api_group_id', 'API Group')
                ->options(
                    function () {
                        $arr = ApiGroup::get(['id', 'name'])->pluck('name', 'id')->toArray();
                        $arr[0] = 'Options';
                        ksort($arr);
                        return $arr;
                    }
                )
                ->load('api_id', route('admin.search.api_by_group'));

            $form->select('api_id', 'API')->options(function () use ($form) {
                if ($form->builder()->isMode(Form\Builder::MODE_EDIT)) {
                    return Api::find($form->model()->api_id)->group->apis()->pluck('name', 'id')->toArray();
                }
            });

            $form->ignore('api_group_id');

            $form->json('variables')->default('{}')->rule('required|json');
            $form->json('queries')->default('{}')->rule('required|json');
            $form->json('requests')->default('{}')->rule('required|json');
            $form->json('headers')->default('{}')->rule('required|json');
        });
    }
}
