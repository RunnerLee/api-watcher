<?php

namespace App\Admin\Controllers;

use App\Models\ApiGroup;
use App\Models\ScheduleRule;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ScheduleRulesController extends Controller
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

            $content->header('Schedule Rules');

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

            $content->header('Schedule Rules');

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

            $content->header('Schedule Rules');

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
        return Admin::grid(ScheduleRule::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->apiGroup()->name('APIs Group');
            $grid->cron_expression('Cron Expression');
            $grid->cron_condition('Cron Condition');
            $grid->created_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ScheduleRule::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->select('api_group_id')->options(
                ApiGroup::has('apis', '>=', '1')->pluck('name', 'id')
            );
            $form->text('cron_expression')->default('* * * * *');
            $form->json('cron_condition')->default(json_encode([
                'week' => [],
                'hour' => [
                    'between' => [
                        'from' => '',
                        'to' => '',
                    ],
                    'unless_between' => [
                        'from' => '',
                        'to' => '',
                    ],
                ],
            ]));

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
