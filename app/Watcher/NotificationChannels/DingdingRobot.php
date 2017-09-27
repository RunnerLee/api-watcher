<?php
/**
 * @author: RunnerLee
 * @email: runnerleer@gmail.com
 * @time: 2017-09
 */

namespace App\Watcher\NotificationChannels;

use Illuminate\Notifications\Notification;
use GuzzleHttp\Client;

class DingdingRobot
{

    const ROBOT_HOST = 'https://oapi.dingtalk.com/robot/send?access_token=';

    protected $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toDingdingRobot($notifiable);
        $content = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => "{$notifiable->apiGroup->name} 监控组告警",
                'text' => $message['content'],
                'hideAvatar' => 0,
                'btnOrientation' => 0,
                'btns' => [
                    [
                        'title' => '妈的! 老子不能忍!',
                        'actionURL' => $message['link'],
                    ],
                ]
                ,
            ],
        ];
        (new Client())->post(
            $this->makeUrl(),
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => \GuzzleHttp\json_encode($content),
            ]
        );
    }

    protected function makeUrl()
    {
        return static::ROBOT_HOST . $this->token;
    }

}
