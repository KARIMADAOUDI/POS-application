<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="mb-4 flex gap-2 overflow-x-auto pb-2">
        <button wire:click="$set('selectedCategory', '')"
            class="px-4 py-1 rounded-full font-semibold shadow transition whitespace-nowrap
                {{ $selectedCategory == '' ? 'bg-indigo-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
            Toutes les catégories
        </button>
        @foreach($categories as $cat)
            <button wire:click="$set('selectedCategory', {{ $cat->id }})"
                class="px-4 py-1 rounded-full font-semibold shadow transition whitespace-nowrap
                    {{ $selectedCategory == $cat->id ? 'bg-indigo-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ $cat->name }}
            </button>
        @endforeach
    </div>
    <div class="mb-4">
        <input type="text" wire:model="search" placeholder="Rechercher un produit..." class="p-2 border rounded w-full" />
    </div>

    @if (session()->has('success'))
        <div class="bg-green-200 text-green-800 p-2 rounded mb-2">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($products as $product)
            <div class="border rounded-lg shadow-lg p-4 flex flex-col items-center bg-white relative hover:shadow-2xl transition">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-24 w-24 object-cover mb-2 rounded">
                @else
                    <div class="h-24 w-24 bg-gray-200 flex items-center justify-center mb-2 rounded">No Image</div>
                @endif
                <div class="font-bold text-lg text-center mb-1">{{ $product->name }}</div>
                <div class="text-gray-600 mb-1">{{ number_format($product->price, 2) }} DH</div>
                <span class="absolute top-2 right-2 bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">Stock: {{ $product->stock }}</span>
                <button wire:click="addToCart({{ $product->id }})"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded mt-2 w-full disabled:opacity-50"
                        @if($product->stock < 1) disabled @endif>
                    {{ $product->stock < 1 ? 'Rupture' : 'Ajouter' }}
                </button>
            </div>
        @empty
            <div class="col-span-4 text-center text-gray-500">Aucun produit trouvé.</div>
        @endforelse
    </div>
</div>
