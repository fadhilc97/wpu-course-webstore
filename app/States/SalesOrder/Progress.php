<?php

declare(strict_tpes=1);

namespace App\States\SalesOrder;

class Progress extends SalesOrderState {
    public function label(): string {
        return "Proses";
    }
}
