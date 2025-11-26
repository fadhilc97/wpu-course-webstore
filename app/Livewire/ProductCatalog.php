<?php

namespace App\Livewire;

use App\Data\ProductCollectionData;
use App\Data\ProductData;
use App\Models\Product;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
  use WithPagination;

  public $queryString = [
    'selected_collections' => ['except', []],
    'search' => ['except', ''],
    'sort_by' => ['except', 'newest'],
  ];

  public array $selected_collections = [];

  public string $search = '';

  public string $sort_by = 'newest'; // latest, price_asc, price_desc

  public function mount() {
    $this->validate();
  }

  protected function rules() {
    return [
      'selected_collections' => 'array',
      'selected_collections.*' => 'integer|exists:tags,id',
      'search' => 'nullable|string|min:3',
      'sort_by' => 'in:newest,latest,price_asc,price_desc'
    ];
  }

  protected function messages() {
    return [
      'selected_collections.*' => 'Invalid filter by collections'
    ];
  }

  public function applyFilters() {
    $this->validate();
    $this->resetPage();
  }

  public function resetFilters() {
    $this->selected_collections = [];
    $this->search = '';
    $this->sort_by = 'newest';

    $this->resetErrorBag();
    $this->resetPage();
  }

  public function render()
  {
    $products = ProductData::collect([]);
    $collections = ProductCollectionData::collect([]);

    if ($this->getErrorBag()->isNotEmpty()) {
      return view('livewire.product-catalog', compact('products', 'collections'));
    }

    $product_query = Product::query();
    $collection_result = Tag::query()->withType('collection')->withCount('products')->get();

    if ($this->search) {
      $product_query->where('name', 'LIKE', "%{$this->search}%");
    }

    if ($this->selected_collections) {
      $product_query->whereHas('tags', function($query) {
        $query->whereIn('id', $this->selected_collections);
      });
    }

    if ($this->sort_by) {
      switch($this->sort_by) {
        case "latest":
          $product_query->oldest();
          break;
        case "price_asc":
          $product_query->orderBy('price', 'asc');
          break;
        case "price_desc":
          $product_query->orderBy('price', 'desc');
          break;
        default:
          $product_query->latest();
          break;
      }
    }

    $products = ProductData::collect($product_query->paginate(9));
    $collections = ProductCollectionData::collect($collection_result);
    
    return view('livewire.product-catalog', compact('products', 'collections'));
  }
}
