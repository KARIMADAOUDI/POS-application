<div>
    <h2 class="text-xl font-bold mb-4">Historique des ventes</h2>
    <table class="w-full mb-4 border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2">N°</th>
                <th class="p-2">Date</th>
                <th class="p-2">Total</th>
                <th class="p-2">Détail</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr class="border-t">
                    <td class="p-2">{{ $order->id }}</td>
                    <td class="p-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="p-2">{{ number_format($order->total, 2) }} DH</td>
                    <td class="p-2">
                        <ul>
                            @foreach($order->orderItems as $item)
                                <li>{{ $item->product->name ?? 'Produit supprimé' }} x {{ $item->quantity }} ({{ number_format($item->subtotal, 2) }} DH)</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-gray-500">Aucune commande trouvée.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
