<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\SalesOrderCreatedEvent;
use App\Mail\SalesOrderCreatedMail;

class SendOrderConfirmationEmailListener
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
    public function handle(SalesOrderCreatedEvent $event): void
    {
        Mail::queue(new SalesOrderCreatedMail($event->sales_order));
    }
}
