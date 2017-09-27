<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MissionAlert extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['dingding-robot'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDingdingRobot($notifiable)
    {
        $content = <<<MESSAGE
### {$notifiable->apiGroup->name} 监控组告警

任务编号: {$notifiable->id}

测试分组: {$notifiable->apiGroup->name}

测试分组: {$notifiable->apiGroup->name}

开始时间: {$notifiable->start_time}

结束时间: {$notifiable->finish_time}

结果总数: {$notifiable->result_count}

失败总数: {$notifiable->unsuccessful_result_count}
MESSAGE;
        return [
            'content' => $content,
            'link' => route('dingding_missions.show', $notifiable->id),
        ];
    }
}
