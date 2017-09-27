<?php

namespace App\Providers;

use App\Admin\Form\Fields\JsonEditor;
use App\Watcher\NotificationChannels\DingdingRobot;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Encore\Admin\Admin;
use Illuminate\Support\ServiceProvider;
use Orangehill\Iseed\IseedServiceProvider;
use Notification;
use Encore\Admin\Form;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ('local' === $this->app->environment()) {
            $this->app->register(IdeHelperServiceProvider::class);
            $this->app->register(IseedServiceProvider::class);
        }

        Notification::extend('dingding-robot', function () {
            return new DingdingRobot(config('watcher.dingding.robot_token'));
        });

        Form::extend('json', JsonEditor::class);
        Admin::$css[] = 'https://unpkg.com/jsoneditor@5.9.3/dist/jsoneditor.min.css';
        Admin::$js[] = 'https://unpkg.com/jsoneditor@5.9.3/dist/jsoneditor.min.js';
    }
}
