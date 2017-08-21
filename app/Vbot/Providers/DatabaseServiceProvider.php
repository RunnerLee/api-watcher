<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-08
 */

namespace App\Vbot\Providers;

use Hanson\Vbot\Foundation\ServiceProviderInterface;
use Hanson\Vbot\Foundation\Vbot;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\DatabaseManager;

class DatabaseServiceProvider implements ServiceProviderInterface
{
    public function register(Vbot $vbot)
    {
        Model::setConnectionResolver(new DatabaseManager($vbot, new ConnectionFactory($vbot)));
    }
}
