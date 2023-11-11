<?php

namespace App\Listeners;

use App\Events\CalificacionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalificacionListener
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
    public function handle(CalificacionEvent $event)
    {
        return $event->calificacion;
    }
}
