<?php

declare(strict_types=1);

namespace App\States\SalesOrder\Transitions;

use Spatie\ModelStates\Transition;
use App\Models\SalesOrder;
use App\States\SalesOrder\Cancel;
use App\Data\SalesOrderData;
use App\Events\SalesOrderCancelledEvent;

class PendingToCancel extends Transition {
    public function __construct(
        private SalesOrder $sales_order
    ) {}

    public function handle() {
        $sales_order = $this->sales_order->update([
            'status' => Cancel::class
        ]);

        event(
            new SalesOrderCancelledEvent(
                SalesOrderData::fromModel($this->sales_order)
            )
        );
    }
}
