<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 leading-tight">
            {{ __('Product List') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-12">
    @if($products->isEmpty())
        <p class="text-center text-gray-600">No products found.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($products as $product)
                <div class="bg-white p-6 rounded-xl shadow-lg transform transition-all duration-300 hover:scale-105 hover:shadow-2xl">
                    <div class="relative">
                        @if ($product->images->isNotEmpty())
                            <div class="carousel-container">
                                @foreach ($product->images as $index => $image)
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}"
                                         class="w-full h-48 object-cover rounded-t-xl mb-4 {{ $index === 0 ? 'block' : 'hidden' }}" id="product-image-{{ $product->id }}-{{ $index }}">
                                @endforeach
                            </div>

                            <button onclick="changeImage('{{ $product->id }}', -1)" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white bg-gray-700 p-2 rounded-full hover:bg-gray-800">
                                &#8592;
                            </button>
                            <button onclick="changeImage('{{ $product->id }}', 1)" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white bg-gray-700 p-2 rounded-full hover:bg-gray-800">
                                &#8594;
                            </button>
                        @else
                            <img src="{{ asset('storage/no-image.jpg') }}" alt="No image available" class="w-full h-48 object-cover rounded-t-xl mb-4">
                        @endif
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 truncate">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-600 mt-2 truncate">{{ $product->description }}</p>
                    <p class="text-lg font-bold text-indigo-600 mt-4">${{ number_format($product->price ?? 0, 2) }}</p>

                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.add') }}" method="post" class="mt-6">
                        @csrf
                        <!-- Quantity Input -->
                        <div class="mb-4">
                            <label for="quantity-{{ $product->id }}" class="font-semibold">Quantity:</label>
                            <input
                                id="quantity-{{ $product->id }}"
                                name="quantity"
                                type="number"
                                min="1"
                                value="1"
                                required
                                class="w-full border border-gray-300 rounded-lg p-2"
                            >
                        </div>

                        <!-- Hidden Product ID -->
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-blue-600 text-white text-lg font-semibold py-3 rounded-lg hover:bg-gradient-to-l hover:from-indigo-600 hover:to-blue-700 transition-all">
                            Add to Cart
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>



    <script>
        function changeImage(productId, direction) {
            const images = document.querySelectorAll(`#product-image-${productId} img`);
            let currentIndex = Array.from(images).findIndex(image => image.classList.contains('block'));
            const totalImages = images.length;

            let newIndex = (currentIndex + direction + totalImages) % totalImages;

            images.forEach(image => image.classList.add('hidden'));
            images[newIndex].classList.remove('hidden');
        }
    </script>
</x-app-layout>
