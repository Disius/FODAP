<?php

namespace App\Notifications;

use App\Models\DeteccionNecesidades;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDeteccionNotification extends Notification implements ShouldQueue
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
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->from($this->user->email)
                    ->line($this->user->email.' añadio un nuevo curso' )
                    ->action('Ir', url('/'))
                    ->line('Por favor inica sesión para verlos');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'email' => $this->user->email,
            'id' => $this->detecciones->id,
            'nombre_curso' => $this->detecciones->nombreCurso,
            'route' => '/desarrollo/detecciones/deteccion',
            'messegue' => "creo una nueva deteccion de necesidades"
        ];
    }
}
