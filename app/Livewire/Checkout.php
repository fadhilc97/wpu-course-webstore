<?php

namespace App\Livewire;

use App\Contract\CartServiceInterface;
use App\Data\CartData;
use App\Data\RegionData;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Number;
use Livewire\Component;
use Spatie\LaravelData\DataCollection;

class Checkout extends Component
{
    public array $data = [
        'full_name' => null,
        'email' => null,
        'phone' => null,
        'address_line' => null,
        'destination_region_code' => null
    ];

    public array $region_selector = [
        'keyword' => null,
        'region_code_selected' => null
    ];

    public array $summaries = [
        'sub_total' => 0,
        'sub_total_formatted' => '-',
        'shipping_total' => 0,
        'shipping_total_formatted' => '-',
        'grand_total' => 0,
        'grand_total_formatted' => '-'
    ];

    public function mount() {
        if (!Gate::inspect('is_stock_available')->allowed()) {
            return redirect()->route('cart');
        }
        $this->calculateTotal();
    }

    public function calculateTotal() {
        data_set($this->summaries, 'sub_total', $this->cart->total);
        data_set($this->summaries, 'sub_total_formatted', $this->cart->total_formatted);

        $shipping_cost = 0;
        data_set($this->summaries, 'shipping_total', $shipping_cost);
        data_set($this->summaries, 'shipping_total_formatted', Number::currency($shipping_cost));

        $grand_total = $this->cart->total + $shipping_cost;
        data_set($this->summaries, 'grand_total', $grand_total);
        data_set($this->summaries, 'grand_total_formatted', Number::currency($grand_total));
    }

    public function updatedRegionSelectorRegionCodeSelected($value) {
        data_set($this->data, 'destination_region_code', $value);
    }

    public function getCartProperty(CartServiceInterface $cart): CartData {
        return $cart->all();
    }

    public function getRegionProperty(): ?RegionData {
        $region_code_selected = data_get($this->region_selector, 'region_code_selected');
        if (!$region_code_selected) {
            return null;
        }

        return $this->regions->toCollection()->first(fn(RegionData $region) => $region->code === $region_code_selected);
    }

    public function getRegionsProperty(): DataCollection {
        $regions = [
            [
                'code' => '101',
                'province' => 'Kepulauan Riau',
                'city' => 'Batam',
                'district' => 'Batam Kota',
                'sub_district' => 'Teluk Tering',
                'postal_code' => '29661',
                'country' => 'Indonesia',
            ],
            [
                'code' => '102',
                'province' => 'Riau',
                'city' => 'Kepulauan Meranti',
                'district' => 'Tasik Putri Puyu',
                'sub_district' => 'Selat Akar',
                'postal_code' => '30303',
                'country' => 'Indonesia',
            ],
        ];

        if (!data_get($this->region_selector, 'keyword')) {
            data_set($this->data, 'destination_region_code', null);
            $regions = [];
        }

        return new DataCollection(
            RegionData::class, $regions
        );        
    }

    public function rules() {
        return [
            'data.full_name' => ['required', 'min:3', 'max:255'],
            'data.email' => ['required', 'email:dns'],
            'data.phone' => ['required', 'min:7', 'max:13'],
            'data.address_line' => ['required', 'min:10', 'max:255'],
            'data.destination_region_code' => ['required'],
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
        return view('livewire.checkout', [
            'cart' => $this->cart
        ]);
    }
}
