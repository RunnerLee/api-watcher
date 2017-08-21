<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-08
 */

namespace App\Vbot\MessageAnswers;

use App\Models\ApiGroup;
use Symfony\Component\Process\PhpExecutableFinder;

class ExecuteTesting implements MessageAnswerInterface
{

    protected $phpExecute = null;

    public function match($message)
    {
        return 0 === strpos($message, '执行分组:');
    }

    public function reply($message)
    {
        $groupName = mb_substr($message, 5);

        if (!$group = ApiGroup::byName($groupName)->first()) {
            return '没有找到分组.';
        }

        if (is_null($this->phpExecute)) {
            $this->phpExecute = (new PhpExecutableFinder())->find(false);
        }

        exec("{$this->phpExecute} artisan monitor:execute {$group->id} > /dev/null 2>&1 &");

        return '任务已发送.';
    }
}
