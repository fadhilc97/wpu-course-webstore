<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\States\SalesOrder\SalesOrderState;
use Spatie\ModelStates\HasStates;

class SalesOrder extends Model
{
    use HasStates;

    protected $with = ['items'];

    protected $casts = [
        'payment_payload' => 'json',
        'status' => SalesOrderState::class
    ];

    public function items(): HasMany {
        return $this->hasMany(SalesOrderItem::class);
    }
}
