<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resources([
        'apis' => ApisController::class,
        'api_groups' => ApiGroupsController::class,
        'fakers' => FakersController::class,
        'schedule_rules' => ScheduleRulesController::class,
        'missions' => MissionsController::class,
    ]);

    $router->get('search/api_by_group', 'SearchController@apisByGroup')->name('admin.search.api_by_group');

});
