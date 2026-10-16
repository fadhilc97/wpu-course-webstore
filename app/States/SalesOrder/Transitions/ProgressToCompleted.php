<?php

declare(strict_types=1);

namespace App\States\SalesOrder\Transitions;

use Spatie\ModelStates\Transition;
use App\Models\SalesOrder;
use App\States\SalesOrder\Completed;
use App\Data\SalesOrderData;
use App\Events\SalesOrderCancelledEvent;

class ProgressToCompleted extends Transition {
    public function __construct(
        private SalesOrder $sales_order
    ) {}

    public function handle() {
        $this->sales_order->update([
            'status' => Completed::class
        ]);

        event(
            new SalesOrdeCancelledEvent(
                SalesOrderData::fromModel($this->sales_order)
            )
        );
    }
}
