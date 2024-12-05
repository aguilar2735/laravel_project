<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- Cart Title on the Left -->
            <h2 class="font-semibold text-3xl text-gray-900 leading-tight">
                {{ __('Cart') }}
            </h2>

            <!-- Total Amount on the Right -->
            <h3 class="text-2xl font-bold text-gray-900">
                Total: ₱{{ number_format($totalAmount, 2) }}
            </h3>
        </div>
    </x-slot>

    

    <div class="container mx-auto px-6 py-12">
    <!-- Purchase Button aligned to the bottom right -->
    <div class="flex justify-end fixed bottom-10 right-10 z-10">
        <a href="{{ route('checkout') }}">
            <button type="button" class="flex items-center bg-gradient-to-r from-indigo-500 to-blue-500 text-white px-6 py-3 rounded-full shadow hover:from-indigo-600 hover:to-blue-600 focus:outline-none focus:ring-4 focus:ring-indigo-400">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Purchase
            </button>
        </a>
    </div>
    </div>

    <div class="container mx-auto px-4 py-12">
    @if (empty($productsInCart))
        <p class="text-center text-gray-600">Your cart is empty.</p>
    @else
        <!-- Grid layout for products in cart -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($productsInCart as $item)
                @php
                    $product = \App\Models\Product::find($item['product_id']);
                @endphp
                <div class="bg-white p-6 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                    <div class="relative">
                        @if ($product->images->isNotEmpty())
                            <div class="carousel-container">
                                @foreach ($product->images as $index => $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-t-xl mb-4 carousel-image {{ $index === 0 ? 'block' : 'hidden' }}" id="product-image-{{ $product->id }}-{{ $index }}">
                                @endforeach
                            </div>
                        @else
                            <img src="{{ asset('storage/no-image.jpg') }}" alt="No image available" class="w-full h-48 object-cover rounded-t-xl mb-4">
                        @endif
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600 mt-2 truncate">{{ $product->description }}</p>
                    <p class="text-lg font-bold text-indigo-600 mt-4">₱{{ number_format($product->price ?? 0, 2) }}</p>

                    <!-- Cart Item Quantity -->
                    <div class="mt-4">
                        <label for="quantity-{{ $product->id }}" class="font-semibold">Quantity:</label>
                        <input
                            id="quantity-{{ $product->id }}"
                            name="quantity"
                            type="number"
                            min="1"
                            value="{{ $item['quantity'] }}"
                            disabled
                            class="w-full border border-gray-300 rounded-lg p-2"
                        >
                    </div>

                    <!-- Product Status -->
                    <div class="mt-2">
                        <p class="font-semibold text-gray-700">
                            Status: 
                            <span class="{{ $item['status'] === 'Paid' ? 'text-green-500' : 'text-red-500' }}">
                                {{ $item['status'] }}
                            </span>
                        </p>
                    </div>

                    <!-- Total Price for this Product -->
                    <p class="mt-2 text-lg font-semibold text-indigo-600">
                        Total: ₱{{ number_format($product->price * $item['quantity'], 2) }}
                    </p>
                </div>
            @endforeach
        </div>
    @endif
    </div>
</x-app-layout>