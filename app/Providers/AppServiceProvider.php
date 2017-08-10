<?php

namespace App\Providers;

use App\Admin\Form\Fields\JsonEditor;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Encore\Admin\Admin;
use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider;

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
        }

        Form::extend('json', JsonEditor::class);
        Admin::$css[] = 'https://unpkg.com/jsoneditor@5.9.3/dist/jsoneditor.min.css';
        Admin::$js[] = 'https://unpkg.com/jsoneditor@5.9.3/dist/jsoneditor.min.js';
    }
}
