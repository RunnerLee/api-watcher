<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('apis', 'ApisController');
    $router->resource('fakers', 'FakersController');

    $router->get('search/api_by_group', 'SearchController@apisByGroup')->name('admin.search.api_by_group');

});
