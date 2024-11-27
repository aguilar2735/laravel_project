<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-gray-900 leading-tight">
            {{ __('Explore Products') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-6 py-12">
        <div class="flex justify-end mb-10">
            <a href="{{ route('products.create') }}">
                <button class="flex items-center bg-gradient-to-r from-indigo-500 to-blue-500 text-white px-6 py-3 rounded-full shadow hover:from-indigo-600 hover:to-blue-600 focus:outline-none focus:ring-4 focus:ring-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Product
                </button>
            </a>
        </div>

        <div>
            @if($products->isEmpty())
                <p class="text-gray-500 text-center text-lg">No products available yet. Start by adding a new product.</p>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach ($products as $product)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-2xl">
                            <div class="relative h-56">
                                @if($product->images->isNotEmpty())
                                    <div class="relative w-full h-full overflow-hidden" id="carousel-{{ $product->id }}">
                                        @foreach ($product->images as $index => $image)
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}"
                                                 class="carousel-image absolute w-full h-full object-cover transition-opacity duration-500"
                                                 style="{{ $index === 0 ? 'opacity: 1;' : 'opacity: 0;' }}">
                                        @endforeach
                                    </div>

                                    <button onclick="changeImage('{{ $product->id }}', -1)"
                                            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-75 transition">
                                        &#8592;
                                    </button>
                                    <button onclick="changeImage('{{ $product->id }}', 1)"
                                            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-3 rounded-full hover:bg-opacity-75 transition">
                                        &#8594;
                                    </button>
                                @else
                                    <img src="{{ asset('storage/no-image.jpg') }}" alt="No image available" class="w-full h-full object-cover">
                                @endif
                            </div>

                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500 mt-2">{{ Str::limit($product->description, 50) }}</p>
                                <p class="text-lg font-bold text-indigo-600 mt-4">${{ number_format($product->price ?? 0, 2) }}</p>
                            </div>

                            <div class="flex justify-between items-center p-6 bg-gray-50">
                                <a href="{{ route('products.edit', $product) }}" class="text-indigo-500 font-semibold hover:text-indigo-600">
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 font-semibold hover:text-red-600">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <script>

            function changeImage(productId, direction) {
                const images = document.querySelectorAll(`#carousel-${productId} img`);
                let currentIndex = Array.from(images).findIndex(image => image.style.opacity === '1');
                const totalImages = images.length;
                let newIndex = (currentIndex + direction + totalImages) % totalImages;

                images.forEach(image => image.style.opacity = '0');
                images[newIndex].style.opacity = '1';
            }
        </script>
</x-app-layout>
