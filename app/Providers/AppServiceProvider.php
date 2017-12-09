<?php

namespace App\Providers;

use App\Admin\Form\Fields\JsonEditor;
use Illuminate\Support\ServiceProvider;
use Encore\Admin\Admin;
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
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Form::extend('json', JsonEditor::class);
        Admin::$css[] = 'https://unpkg.com/jsoneditor@5.9.3/dist/jsoneditor.min.css';
        Admin::$js[] = 'https://unpkg.com/jsoneditor@5.9.3/dist/jsoneditor.min.js';
    }
}
