<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class Cart extends Component
{
    public $discount = 0;
    public $tax = 0;
    public $shipping = 0;
    public $cart = [];
    public $cartDetails = [];
    public $total = 0;
    public $discountMode = 'auto';

    protected $listeners = ['cartUpdated' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $this->cart = session()->get('cart', []);
        $this->cartDetails = [];
        $this->total = 0;

        foreach ($this->cart as $productId => $qty) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal = $product->price * $qty;
                $this->cartDetails[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                ];
                $this->total += $subtotal;
            }
        }
        // Calcul de la remise selon le mode choisi
        if ($this->discountMode === 'auto') {
            $this->discount = $this->total > 1000 ? round($this->total * 0.05, 2) : 0;
        }
    }

    public function removeFromCart($productId)
    {
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);
        $this->cart = $cart;
        $this->dispatch('cartUpdated');
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->dispatch('cartUpdated');
    }

    public function checkout()
    {
        if (empty($this->cartDetails)) {
            session()->flash('success', 'Votre panier est vide.');
            return;
        }

        DB::beginTransaction();
        try {
            $order = \App\Models\Order::create([
                'user_id' => optional(auth())->id ?? 1, // Utilisateur connecté ou 1 par défaut
                'total' => $this->total + $this->tax + $this->shipping - $this->discount,
                'tax' => $this->tax,
                'discount' => $this->discount,
                'shipping' => $this->shipping,
            ]);

            foreach ($this->cartDetails as $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
                // Diminuer le stock
                $product = \App\Models\Product::find($item['id']);
                if ($product) {
                    $product->stock = max(0, $product->stock - $item['qty']);
                    $product->save();
                }
            }

            DB::commit();
            session()->forget('cart');
            $this->dispatch('cartUpdated');
            session()->flash('success', 'Commande validée et enregistrée avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('success', 'Erreur lors de la validation de la commande : ' . $e->getMessage());
        }
    }

    public function updateQty($productId, $qty)
    {
        $cart = session()->get('cart', []);
        if ($qty > 0) {
            $cart[$productId] = $qty;
        } else {
            unset($cart[$productId]);
        }
        session()->put('cart', $cart);
        $this->dispatch('cartUpdated');
    }

    public function updatedCart($value, $key)
    {
        $productId = $key;
        $qty = (int)$value;
        $cart = session()->get('cart', []);
        if ($qty > 0) {
            $cart[$productId] = $qty;
        } else {
            unset($cart[$productId]);
        }
        session()->put('cart', $cart);
        $this->refreshCart();
    }

    public function updatedDiscountMode()
    {
        $this->refreshCart();
    }

    public function render()
    {
        if ($this->discountMode === 'auto') {
            $this->discount = $this->total > 1000 ? round($this->total * 0.05, 2) : 0;
        }
        return view('livewire.cart');
    }
}