<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-08
 */

namespace App\Vbot\MessageAnswers;

use App\Models\ApiGroup;

class QueryApiGroup implements MessageAnswerInterface
{

    public function match($message)
    {
        return 0 === strpos($message, '查看接口分组:');
    }

    public function reply($message)
    {
        $group = ApiGroup::byName(mb_substr($message, 7))->first();

        return <<<MESSAGE
分组名称: {$group->name}
分组API数量: {$group->apis()->count()}
已完成测试任务数: {$group->missions()->count()}
MESSAGE;
    }
}
