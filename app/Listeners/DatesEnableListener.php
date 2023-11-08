<?php

namespace App\Listeners;

use App\Events\DatesEnableEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DatesEnableListener
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
    public function handle(DatesEnableEvent $event)
    {
        return $event->dates;
    }
}
