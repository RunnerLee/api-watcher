<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', function () {
        return redirect()->route('missions.index');
    });

    $router->resource('apis', 'ApisController');
    $router->resource('api_groups', 'ApiGroupsController');
    $router->resource('fakers', 'FakersController');
    $router->resource('schedule_rules', 'ScheduleRulesController');
    $router->resource('missions', 'MissionsController');

    $router->get('search/api_by_group', 'SearchController@apisByGroup')->name('admin.search.api_by_group');

});
