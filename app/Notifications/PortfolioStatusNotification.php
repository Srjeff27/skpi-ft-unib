<?php

namespace App\Notifications;

use App\Models\Portfolio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class PortfolioStatusNotification extends Notification
{
    use Queueable;

    public function __construct(public Portfolio $portfolio, public string $status, public ?string $message = null)
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
            'portfolio_id' => $this->portfolio->id,
            'status' => $this->status,
            'title' => match ($this->status) {
                'verified' => 'Portofolio disetujui',
                'rejected' => 'Portofolio ditolak',
                'pending' => 'Perbaikan portofolio diminta',
                default => 'Status portofolio diperbarui',
            },
            'message' => $this->message,
            'judul_kegiatan' => $this->portfolio->judul_kegiatan,
        ];
    }
}

