<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-08
 */

namespace App\Vbot\MessageAnswers;

interface MessageAnswerInterface
{

    public function match($message);

    public function reply($message);

}
