<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-08
 */

namespace App\Vbot\MessageHandler;

use App\Models\ApiGroup;
use Hanson\Vbot\Extension\AbstractMessageHandler;
use Hanson\Vbot\Message\Text;
use Illuminate\Support\Collection;

class MissionMessageHandler extends AbstractMessageHandler
{

    public $name = 'watcher_mission';

    public $zhName = '';

    public $version = '1.0.0';

    /**
     * 注册拓展时的操作.
     */
    public function register()
    {
        // TODO: Implement register() method.
    }

    /**
     *
     * @param Collection $message
     *
     * @return mixed
     */
    public function handler(Collection $message)
    {
//        print_r($message);
        if ('text' === $message['type'] && 'Group' === $message['fromType']) {
            if ('查看接口分组:' === mb_substr($message['pure'], 0, 7)) {
                $group = ApiGroup::find(mb_substr($message['pure'], 7));

                Text::send($message['from']['UserName'], <<<MESSAGE
分组名称: {$group->name}
分组API数量: {$group->apis()->count()}
已完成测试任务数: {$group->missions()->count()}
MESSAGE
);
            }
        }
    }
}
