<?php

namespace App\Admin\Controllers;

use Admin;
use App\Models\ApiGroup;
use App\Models\Mission;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Collapse;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;

class MissionsController extends Controller
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

            $content->header('Missions');

            $content->body($this->grid());
        });
    }

    public function show(Mission $mission)
    {
        return Admin::content(function (Content $content) use ($mission) {

            $content->header('Missions');

            $content->row(function (Row $row) use ($mission) {
                foreach ($mission->results as $result) {
                    $tab = new Tab();
                    $tab->add('Info', view('weight.info', [
                        'result' => $result
                    ]));
                    $tab->add('Request', view('weight.info', [
                        'result' => $result
                    ]));
                    $tab->add('Headers', view('weight.headers', [
                        'headers' => json_decode($result->response_headers, true)
                    ]));
                    $tab->add('Body', build_json_viewer($result->response_content));
                    $box = new Box("{$result->api->name} Faker: {$result->faker_id}", $tab);
                    if ('no' === $result->is_successful) {
                        $box->style('danger');
                    }
                    $row->column(12, $box);
                }
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

            $content->header('Missions');

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

            $content->header('Missions');

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
        return Admin::grid(Mission::class, function (Grid $grid) {

            $grid->id('ID')->sortable()->display(function ($value) {
                return '<a href="' . route('missions.show', $value) . '">' . "{$value}</a>";
            });
            $grid->apiGroup()->name('APIs Group');
            $grid->start_time('Start Time');
            $grid->finish_time('finish Time');
            $grid->result_count('Results');
            $grid->unsuccessful_result_count('Unsuccessful Results');
            $grid->created_at();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->disableIdFilter();
                $filter->equal('api_group_id', 'Group')->select(
                    ApiGroup::all()->pluck('name', 'id')
                );
            });

            $grid->disableActions();
            $grid->disableExport();
            $grid->disableCreation();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Mission::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
