<?php

namespace App\Notifications;

use App\Models\DeteccionNecesidades;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ObservacionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $detecciones;
    public $user;

    public function __construct(DeteccionNecesidades $detecciones, User $user)
    {
        $this->detecciones = $detecciones;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database',  'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->from(auth()->user()->email)
                    ->line(auth()->user()->email.' ha agregado una observación')
                    ->action('Ir', url('/'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->detecciones->id,
            'email' => auth()->user()->email,
            'route' => '/deteccion',
            'departamento' => $this->detecciones->departamento,
            'messegue' => 'agrego una observacion'
        ];
    }
}
