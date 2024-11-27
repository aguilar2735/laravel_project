<x-app-layout>
    <script src="https://cdn.tailwindcss.com"></script>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-6 py-12">
        <h3 class="text-3xl font-semibold text-gray-800 mb-8">Edit Product</h3>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-8 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="block text-lg font-medium text-gray-700">Product Name</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                       class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="form-group">
                <label for="description" class="block text-lg font-medium text-gray-700">Description</label>
                <textarea name="description"
                          class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="price" class="block text-lg font-medium text-gray-700">Price</label>
                <input type="text" name="price" value="{{ old('price', $product->price) }}"
                       class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="form-group">
                <label for="images" class="block text-lg font-medium text-gray-700">Product Images</label>
                <input type="file" name="images[]" multiple
                       class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex justify-end space-x-4">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Update Product
                </button>
                <a href="{{ route('dashboard') }}"
                   class="bg-gray-300 text-gray-800 px-6 py-3 rounded-lg shadow-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
