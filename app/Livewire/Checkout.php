<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Checkout extends Component
{
    public array $data = [
        'full_name' => null,
        'email' => null,
        'phone' => null,
        'address_line' => null
    ];

    public function mount() {
        if (!Gate::inspect('is_stock_available')->allowed()) {
            return redirect()->route('cart');
        }
    }

    public function rules() {
        return [
            'data.full_name' => ['required', 'min:3', 'max:255'],
            'data.email' => ['required', 'email:dns'],
            'data.phone' => ['required', 'min:7', 'max:13'],
            'data.address_line' => ['required', 'min:10', 'max:255'],
        ];
    }

    public function messages() {
        return [
            'required' => 'Required',
            'email' => 'Invalid email',
            'between' => 'Is not between :min - :max character'
        ];
    }

    public function placeAnOrder() {
        $this->validate();
        dd($this->data);
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
