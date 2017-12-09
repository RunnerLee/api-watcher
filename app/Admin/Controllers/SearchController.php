<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-07
 */

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Api;
use App\Models\ApiGroup;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function apisByGroup(Request $request)
    {
        return ApiGroup::findOrFail((int)$request->get('q'))->apis()->get([
            'id', 'name as text'
        ]);
    }

}
