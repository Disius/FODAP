<?php

namespace App\Listeners;

use App\Events\DeleteDeteccionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeleteDeteccionListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DeleteDeteccionEvent $event)
    {
        return $event->deteccion;
    }
}
