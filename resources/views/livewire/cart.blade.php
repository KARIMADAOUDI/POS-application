<div class="bg-white rounded-lg shadow p-4">
    <h2 class="text-xl font-bold mb-4">Panier</h2>
    <table class="w-full mb-4 text-sm">
        <thead>
            <tr class="bg-gray-100">
                <th class="text-left p-2">Produit</th>
                <th class="p-2">Qté</th>
                <th class="p-2">Prix</th>
                <th class="p-2">Sous-total</th>
                <th class="p-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cartDetails as $item)
                <tr>
                    <td class="p-2">{{ $item['name'] }}</td>
                    <td>
                        <input type="number" min="1" wire:model.lazy="cart.{{ $item['id'] }}"
                            class="w-16 border rounded p-1 text-center" />
                    </td>
                    <td>{{ number_format($item['price'], 2) }} DH</td>
                    <td>{{ number_format($item['subtotal'], 2) }} DH</td>
                    <td>
                        <button wire:click="removeFromCart({{ $item['id'] }})"
                            class="text-red-600 hover:underline">Supprimer</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-gray-400 py-8">Aucun produit dans le panier.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mb-2 flex items-center gap-4">
        <label class="flex items-center gap-1 text-xs">
            <input type="radio" wire:model="discountMode" value="auto"> Automatique (5% si total > 1000 DH)
        </label>
        <label class="flex items-center gap-1 text-xs">
            <input type="radio" wire:model="discountMode" value="manual"> Manuelle
        </label>
    </div>
    <div class="grid grid-cols-2 gap-2 mb-2">
        @if($discountMode === 'manual')
        <div>
            <label class="block text-xs text-gray-500 mb-1">Remise (Discount)</label>
            <input type="number" step="0.01" wire:model.lazy="discount" class="w-full border rounded p-1 text-right" />
        </div>
        @endif
        <div>
            <label class="block text-xs text-gray-500 mb-1">Taxe (%)</label>
            <input type="number" step="0.01" wire:model.lazy="tax" class="w-full border rounded p-1 text-right" />
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">Livraison (Shipping)</label>
            <input type="number" step="0.01" wire:model.lazy="shipping" class="w-full border rounded p-1 text-right" />
        </div>
    </div>
    @if(count($cartDetails) > 0)
        <div class="mb-2">Sous-total : <span class="font-bold">{{ number_format($total, 2) }} DH</span></div>
        <div class="mb-2">Remise : <span class="text-green-700">-{{ number_format($discount, 2) }} DH</span></div>
        <div class="mb-2">Taxe : <span class="text-blue-700">+{{ number_format($tax, 2) }} DH</span></div>
        <div class="mb-2">Livraison : <span class="text-blue-700">+{{ number_format($shipping, 2) }} DH</span></div>
        <div class="mb-4 font-bold">Total à payer : {{ number_format($total + $tax + $shipping - $discount, 2) }} DH</div>
        <div class="flex gap-2 mb-2">
            <button wire:click="checkout"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Pay Now</button>
            <button wire:click="clearCart"
                class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Vider le panier</button>
            <button onclick="printTicket()"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Imprimer le ticket</button>
        </div>
        <div id="ticket" class="max-w-xs mx-auto p-4 bg-white rounded shadow text-sm font-mono border mt-4">
            <div class="text-center mb-2">
                <div class="font-bold text-lg">Ma Boutique</div>
                <div>{{ now()->format('d/m/Y H:i') }}</div>
                <div>Ticket #{{ uniqid() }}</div>
            </div>
            <hr class="my-2">
            <table class="w-full mb-2">
                <thead>
                    <tr>
                        <th class="text-left">Produit</th>
                        <th>Qté</th>
                        <th>Prix</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartDetails as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-center">{{ $item['qty'] }}</td>
                            <td class="text-right">{{ number_format($item['price'], 2) }}</td>
                            <td class="text-right">{{ number_format($item['subtotal'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr class="my-2">
            <div class="flex justify-between"><span>Sous-total</span><span>{{ number_format($total, 2) }} DH</span></div>
            <div class="flex justify-between"><span>Remise</span><span>-{{ number_format($discount, 2) }} DH</span></div>
            <div class="flex justify-between"><span>Taxe</span><span>+{{ number_format($tax, 2) }} DH</span></div>
            <div class="flex justify-between"><span>Livraison</span><span>+{{ number_format($shipping, 2) }} DH</span></div>
            <div class="flex justify-between font-bold text-lg border-t mt-2 pt-2"><span>Total</span><span>{{ number_format($total + $tax + $shipping - $discount, 2) }} DH</span></div>
            <hr class="my-2">
            <div class="text-center mt-2">Merci pour votre achat !</div>
        </div>
        <script>
        function printTicket() {
            var printContents = document.getElementById('ticket').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
        </script>
    @endif
</div>