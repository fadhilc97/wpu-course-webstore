<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Events\SalesOrderCancelledEvent;
use App\Mail\SalesOrderCancelledMail;

class SalesOrderCancelledListener
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
    public function handle(SalesOrderCancelledEvent $event): void
    {
        Mail::queue(
            new SalesOrderCancelledMail($event->sales_order)
        );
    }
}
