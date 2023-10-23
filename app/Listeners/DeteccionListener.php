<?php

namespace App\Listeners;

use App\Events\DeteccionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeteccionListener
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
    public function handle(DeteccionEvent $event)
    {
        return $event->detecciones;
    }
}
