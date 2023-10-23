<?php

namespace App\Listeners;

use App\Events\CursosAceptados;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CursosListener
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
    public function handle(CursosAceptados $event)
    {
        return $event->cursos;
    }
}
