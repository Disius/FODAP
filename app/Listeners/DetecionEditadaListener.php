<?php

namespace App\Listeners;

use App\Events\DeteccionEditadaEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DetecionEditadaListener
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
    public function handle(DeteccionEditadaEvent $event)
    {
        return $event->deteccion;
    }
}
