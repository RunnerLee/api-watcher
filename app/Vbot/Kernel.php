<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-08
 */

namespace App\Vbot;

use App\Vbot\Providers\DatabaseServiceProvider;
use Dotenv\Dotenv;
use Hanson\Vbot\Foundation\Vbot;
use Illuminate\Foundation\EnvironmentDetector;

class Kernel extends Vbot
{

    public function __construct(array $config = [])
    {
        $this->providers[] = DatabaseServiceProvider::class;
        parent::__construct($config);
    }

}
