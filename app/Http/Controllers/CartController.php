<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        // Get the cart for the authenticated user
    $cart = Cart::where('user_id', Auth::id())->first();

    if ($cart) {
        // Decode the products JSON field to an array
        $productsInCart = json_decode($cart->products, true);
    } else {
        // If the user doesn't have a cart, return an empty array
        $productsInCart = [];
    }

    // Pass the products to the view
    return view('cart', compact('productsInCart'));
    }
    
}
