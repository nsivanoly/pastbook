<?php

namespace App\Listeners;

use App\Jobs\SendEmailJob;
use Illuminate\Auth\Events\Registered;

class SendEmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Registered $event
     */
    public function handle(Registered $event)
    {
        SendEmailJob::dispatch($event);
    }
}
