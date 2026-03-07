<?php

namespace App\Livewire;

use App\Contract\CartServiceInterface;
use App\Data\ProductData;
use Livewire\Component;

class CartItemRemove extends Component
{
    public string $sku;

    public function mount(ProductData $product) {
        $this->sku = $product->sku;
    }

    public function removeCartItem(CartServiceInterface $cartService) {
        $cartService->remove($this->sku);

        session()->flash('success', "Product {$this->sku} already removed");

        $this->dispatch('cart-item-removed');

        return redirect()->route('cart');
    }

    public function render()
    {
        return view('livewire.cart-item-remove');
    }
}
