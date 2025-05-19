<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class OrderHistory extends Component
{
    public $orders = [];

    public function mount()
    {
        $this->orders = Order::with('orderItems.product')->orderBy('created_at', 'desc')->take(20)->get();
    }

    public function render()
    {
        return view('livewire.order-history');
    }
}
