<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-09
 */

namespace App\Http\Controllers;

use App\Models\Mission;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Tab;

class MissionsController extends Controller
{

    public function show($id)
    {
        $mission = Mission::findOrFail($id);

        $row = new Row();

        foreach ($mission->results()->orderBy('is_successful', 'desc')->get() as $result) {
            $tab = new Tab();
            $tab->add('Info', view('weight.info', [
                'result' => $result
            ]));
            $tab->add('Faker', build_json_viewer(json_encode([
                'variables' => json_decode($result->faker->variables),
                'queries' => json_decode($result->faker->queries),
                'requests' => json_decode($result->faker->requests),
                'headers' => json_decode($result->faker->headers),
            ])));
            $tab->add('Headers', view('weight.headers', [
                'headers' => json_decode($result->response_headers, true)
            ]));
            if (is_array(json_decode($result->response_content, true))) {
                $tab->add('Body', build_json_viewer($result->response_content));
            } else {
                $tab->add('Body', view('weight.raw', [
                    'content' => $result->response_content
                ]));
            }
            $box = new Box("{$result->api->name} Faker: {$result->faker_id}", $tab);
            if ('no' === $result->is_successful) {
                $box->style('danger');
            }
            $row->column(12, $box);
        }

        return view('index', [
            'content' => $row,
        ]);
    }

}
