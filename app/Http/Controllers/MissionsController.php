<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-09
 */

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Notifications\MissionAlert;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Tab;
use Notification;

class MissionsController extends Controller
{

    public function show($id)
    {
        $mission = Mission::findOrFail($id);

        $row = new Row();

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

        return view('index', [
            'title' => 123,
            'content' => $row,
        ]);
    }

}
