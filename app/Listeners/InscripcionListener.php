<?php

namespace App\Listeners;

use App\Events\InscripcionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InscripcionListener
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
    public function handle(InscripcionEvent $event)
    {
        return $event->inscritos;
    }
}
