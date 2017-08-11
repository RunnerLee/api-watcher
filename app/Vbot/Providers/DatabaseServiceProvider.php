<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-08
 */

namespace App\Vbot\Providers;

use Hanson\Vbot\Foundation\ServiceProviderInterface;
use Hanson\Vbot\Foundation\Vbot;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;
use Illuminate\Contracts\Queue\EntityResolver;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\QueueEntityResolver;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Database\DatabaseManager;

class DatabaseServiceProvider implements ServiceProviderInterface
{

    /**
     * @var Vbot
     */
    protected $app;

    public function register(Vbot $vbot)
    {
        $this->app = $vbot;

        $this->registerConnectionServices();

//        $this->registerEloquentFactory();

//        $this->registerQueueableEntityResolver();

        Model::setConnectionResolver($this->app['db']);
    }

    protected function registerConnectionServices()
    {
        $this->app->singleton('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });

        $this->app->singleton('db', function ($app) {
            return new DatabaseManager($app, $app['db.factory']);
        });

//        $this->app->bind('db.connection', function ($app) {
//            return $app['db']->connection();
//        });
    }

//    protected function registerEloquentFactory()
//    {
//        $this->app->singleton(FakerGenerator::class, function ($app) {
//            return FakerFactory::create($app['config']->get('app.faker_locale', 'en_US'));
//        });
//
//        $this->app->singleton(EloquentFactory::class, function ($app) {
//            return EloquentFactory::construct(
//                $app->make(FakerGenerator::class), $this->app->databasePath('factories')
//            );
//        });
//    }

//    protected function registerQueueableEntityResolver()
//    {
//        $this->app->singleton(EntityResolver::class, function () {
//            return new QueueEntityResolver;
//        });
//    }
}
