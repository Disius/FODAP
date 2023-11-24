<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocenteInscripcion extends Notification implements ShouldQueue
{
    use Queueable;
    public $curso;
    public $user;
    /**
     * Create a new notification instance.
     */
    public function __construct($user, $curso)
    {
        $this->user = $user;
        $this->curso = $curso;
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
            'id' => $this->curso->id,
            'nombre_curso' => $this->curso->nombreCurso,
            'route' => '/docente/mis-cursos',
            'messegue' => "te inscribio a un curso"
        ];
    }
}
