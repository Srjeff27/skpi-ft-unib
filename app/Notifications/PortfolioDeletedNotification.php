<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PortfolioDeletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private string $portfolioTitle;
    private string $reason;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $portfolioTitle, string $reason)
    {
        $this->portfolioTitle = $portfolioTitle;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Portofolio Dihapus',
            'message' => 'Portofolio Anda "' . $this->portfolioTitle . '" telah dihapus oleh verifikator.',
            'reason' => $this->reason,
            'action' => route('student.portfolios.index'), // Link to portfolio index
        ];
    }
}
