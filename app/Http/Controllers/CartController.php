<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        // Get the cart for the authenticated user or create a new one
        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['products' => json_encode([])] // Initialize products as an empty array
        );
        
        // Decode the products from the cart
        $productsInCart = json_decode($cart->products, true);
        
        // Add the new product to the array
        $found = false;
        foreach ($productsInCart as &$item) {
            if ($item['product_id'] == $validated['product_id']) {
                // If the product already exists, just update the quantity
                $item['quantity'] += $validated['quantity'];
                $found = true;
                break;
            }
        }

        // If the product doesn't exist, add it to the cart
        if (!$found) {
            $productsInCart[] = $validated;
        }
        
        // Encode the updated products array back to JSON
        $cart->products = json_encode($productsInCart);
        
        // Save the updated cart
        $cart->save();

        return redirect()->route('cart')->with('success', 'Product added to cart!');
    }

    public function viewCart()
{
    $cart = Cart::where('user_id', Auth::id())->first();

    if ($cart) {
        $productsInCart = json_decode($cart->products, true);
        foreach ($productsInCart as &$item) {
            $item['status'] = $cart->status ?? 'Not Paid'; // Add status to each item based on the cart's status
        }
    } else {
        $productsInCart = [];
    }

    // Calculate total amount
    $totalAmount = array_sum(array_map(function ($item) {
        $product = \App\Models\Product::find($item['product_id']);
        return $product->price * $item['quantity'];
    }, $productsInCart));

    return view('cart', compact('productsInCart', 'totalAmount', 'cart'));
}

}
