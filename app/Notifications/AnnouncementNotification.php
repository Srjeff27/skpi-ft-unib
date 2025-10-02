<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AnnouncementNotification extends Notification
{
    use Queueable;

    public function __construct(public Announcement $announcement)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'announcement',
            'title' => $this->announcement->title,
            'message' => strip_tags((string) $this->announcement->message),
            'published_at' => optional($this->announcement->published_at)->toDateTimeString(),
        ];
    }
}

