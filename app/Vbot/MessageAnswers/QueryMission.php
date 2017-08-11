<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-08
 */

namespace App\Vbot\MessageAnswers;

use App\Models\Mission;

class QueryMission implements MessageAnswerInterface
{

    public function match($message)
    {
        return 0 === strpos($message, '查看任务:');
    }

    public function reply($message)
    {
        if (!$mission = Mission::find(mb_substr($message, 5))) {
            return '任务不存在.';
        }
        $url = vbot()['config']['url'] . "/admin/missions/{$mission->id}";

        return <<<MESSAGE
任务编号: {$mission->id}
测试分组: {$mission->apiGroup->name}
开始时间: {$mission->start_time}
结束时间: {$mission->finish_time}
结果总数: {$mission->result_count}
失败总数: {$mission->unsuccessful_result_count}
任务保存: {$mission->created_at}
查看任务: {$url}
MESSAGE;
    }
}
