<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\SalesOrderCreated;
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
    public function handle(SalesOrderCreated $event): void
    {
        Mail::queue(new SalesOrderCreatedMail($event->sales_order));
    }
}
