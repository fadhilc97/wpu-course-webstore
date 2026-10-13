<?php

declare(strict_tpes=1);

namespace App\States\SalesOrder;

class Pending extends SalesOrderState {
    public function label(): string {
        return "Menunggu pembayaran";
    }
}
