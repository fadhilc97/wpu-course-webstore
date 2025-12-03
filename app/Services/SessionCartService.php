<?php
declare(strict_types=1);

namespace App\Services;

use App\Data\CartData;
use App\Data\CartItemData;
use App\Contract\CartServiceInterface;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;
use Illuminate\Support\Facades\Session;

class SessionCartService implements CartServiceInterface {
  protected string $session_key = 'cart';
  
  protected function load(): DataCollection {
    $raw = Session::get($this->session_key, []);

    return new DataCollection(CartItemData::class, $raw);
  }

  protected function save(Collection $items) {
    Session::put($this->session_key, $items->values()->all());
  }

  public function addOrUpdate(CartItemData $item): void{
    // 1. Ambil data
    $collection = $this->load()->toCollection();
    $updated = false;

    // 2. Lakukan pemetaan update data
    $cart = $collection->map(function(CartItemData $prev_item) use ($item, &$updated) {
      if ($prev_item->sku === $item->sku) {
        $updated = true;
        return $item;
      }
      return $prev_item;
    })->values()->collect();

    if (!$updated) {
      $cart->push($item);
    }

    // 3. Save
    $this->save($cart);
  }

  public function remove(string $sku): void{
    $cart = $this->load()->toCollection()->reject(fn(CartItemData $item) => $item->sku === $sku)->values()->collect();

    $this->save($cart);
  }
  
  public function getItemBySku(string $sku): CartItemData{
    return $this->load()->toCollection()->first(fn(CartItemData $item) => $item->sku === $sku);
  }
  
  public function all(): CartData{
    return new CartData($this->load());
  }
}