<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class PaymentData extends Data
{
    public function __construct(
        public string $driver,
        public string $method,
        public string $label,
        public array $payload = []
    ) {}
}
