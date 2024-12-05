<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function checkout()
    {
        // Get the cart for the authenticated user
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart) {
            return redirect()->route('cart')->with('error', 'Your cart is empty.');
        }

        // Calculate the total amount for the cart
        $productsInCart = json_decode($cart->products, true);
        $totalAmount = 0;
        foreach ($productsInCart as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            if ($product) {
                $totalAmount += $product->price * $item['quantity'];
            }
        }

        // Set Stripe API key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Create a PaymentIntent with the total amount
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100, // Amount in cents
                'currency' => 'php',
                'metadata' => ['integration_check' => 'accept_a_payment'],
            ]);
        } catch (\Exception $e) {
            return redirect()->route('cart')->with('error', 'Error creating payment intent: ' . $e->getMessage());
        }

        // Send the client secret to the front end for Stripe
        return view('checkout', [
            'clientSecret' => $paymentIntent->client_secret
        ]);
    }

    public function paymentSuccess(Request $request)
{
    // Get the payment intent ID from the request (passed after successful Stripe payment)
    $paymentIntentId = $request->input('payment_intent');

    // Verify the payment intent with Stripe
    try {
        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        // Check if payment succeeded
        if ($paymentIntent->status == 'succeeded') {

            // Find the cart for the authenticated user
            $cart = Cart::where('user_id', Auth::id())->first();

            if ($cart) {
                // Decode the products in the cart
                $productsInCart = json_decode($cart->products, true);

                // Update the status of each product to 'Paid'
                foreach ($productsInCart as &$item) {
                    $item['status'] = 'Paid'; // Mark the item as 'Paid'
                }

                // Update the cart's products and change the cart status to 'Paid'
                $cart->products = json_encode($productsInCart);
                $cart->status = 'Paid'; // Change cart status to 'Paid'
                $cart->save();

                return redirect()->route('cart')->with('success', 'Payment successful! Your order has been marked as Paid.');
            }
        } else {
            return redirect()->route('payment.failed')->with('error', 'Payment failed. Please try again.');
        }
    } catch (\Exception $e) {
        return redirect()->route('payment.failed')->with('error', 'Payment verification failed: ' . $e->getMessage());
    }
}


    public function paymentFailed()
    {
        // Handle payment failure and redirect back to the cart page with an error
        return redirect()->route('cart')->with('error', 'Payment failed. Please try again.');
    }
}
