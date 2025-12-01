<?php

namespace App\Livewire;

use Livewire\Component;

class AddToCart extends Component
{
  public int $quantity = 1;

  public function addToCart() {
  }

  public function render()
  {
    return view('livewire.add-to-cart');
  }
}
