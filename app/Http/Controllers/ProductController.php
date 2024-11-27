<?php

// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function dashboard()
    {
        // Fetch products with images to display on the dashboard
        $products = Product::with('images')->get();
        return view('dashboard', compact('products'));
    }
    public function product_list()
    {
        // Fetch all products from the database
        $products = Product::all();

        // Pass the products to the view
        return view('product_list', compact('products'));
    }

    public function create()
    {
        // Render the product creation form
        return view('products.create');
    }

    public function store(Request $request)
    {
        // Handle storing the product data (validation, saving, etc.)
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Create the product
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('product_images', 'public');
                $product->images()->create(['image_path' => $imagePath]);
            }
        }

        // Redirect back to the dashboard or show a success message
        return redirect()->route('dashboard')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::with('images')->findOrFail($id); // Load product with images

        return view('products.edit', compact('product')); // Return the edit view with the product data
    }

    // Update the product in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // If there are new images, handle the file uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                $product->images()->create(['image_path' => $imagePath]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Product updated successfully!');
    }

    // Delete the product from the database
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('dashboard')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Failed to delete product.');
        }
    }
}
