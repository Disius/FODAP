<?php

namespace App\Listeners;

use App\Events\ObservacionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ObservacionListener
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
    public function handle(ObservacionEvent $event)
    {
        return $event->deteccion;
    }
}
