<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;

class ProductList extends Component
{
    public $search = '';
    public $selectedCategory = '';
    public $categories = [];

    public function mount()
    {
        $this->categories = Category::all();
    }

    public function addToCart($productId)
    {
        $cart = session()->get('cart', []);
        $product = Product::find($productId);
        if (!$product || $product->stock < 1) {
            session()->flash('success', 'Stock insuffisant !');
            return;
        }
        if (isset($cart[$productId])) {
            if ($cart[$productId] < $product->stock) {
                $cart[$productId]++;
            } else {
                session()->flash('success', 'Stock insuffisant !');
                return;
            }
        } else {
            $cart[$productId] = 1;
        }
        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');
        session()->flash('success', 'Produit ajouté au panier !');
    }

    public function render()
    {
        $products = Product::when($this->selectedCategory, function($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->where('name', 'like', '%'.$this->search.'%')
            ->get();
        return view('livewire.product-list', [
            'products' => $products,
            'categories' => $this->categories,
        ]);
    }
}
