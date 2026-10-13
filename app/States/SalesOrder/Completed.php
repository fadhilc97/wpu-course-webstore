<?php

declare(strict_tpes=1);

namespace App\States\SalesOrder;

class Completed extends SalesOrderState {
    public function label(): string {
        return "Selesai";
    }
}
