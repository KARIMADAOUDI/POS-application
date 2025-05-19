<x-app-layout>
    <div class="flex justify-end p-4">
        <a href="{{ route('orders') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">Voir l'historique</a>
    </div>
    <div class="flex flex-col md:flex-row gap-4 p-4">
        <div class="w-full md:w-1/3">
            @livewire('cart')
        </div>
        <div class="w-full md:w-2/3">
            @livewire('product-list')
        </div>
    </div>
</x-app-layout> 