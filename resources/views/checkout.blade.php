<!-- resources/views/checkout.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://js.stripe.com/v3/"></script>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6">Complete Your Payment</h1>

        <form id="payment-form" class="space-y-4">
            <div>
                <label for="card-element" class="block text-gray-700 text-sm font-medium">Credit or Debit Card</label>
                <div id="card-element" class="mt-2">
                    <!-- Stripe Card Element will be inserted here -->
                </div>
                <div id="card-errors" class="mt-2 text-red-600 text-sm" role="alert"></div>
            </div>

            <div class="flex justify-center">
                <button id="submit" class="w-full bg-green-500 text-white py-3 rounded-lg text-lg font-semibold hover:bg-green-600 disabled:bg-gray-400 ">
                    Pay Now
                </button>
            </div>

            <div id="loading" class="text-center mt-4 text-green-500" style="display: none;">
                <p>Processing your payment...</p>
            </div>
        </form>
    </div>


    <script type="text/javascript">
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");
        var elements = stripe.elements();
        var card = elements.create('card');
        card.mount('#card-element');

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const {paymentIntent, error} = await stripe.confirmCardPayment("{{ $clientSecret }}", {
        payment_method: {
            card: card
        }
    });

    if (error) {
        // Show error message
        document.getElementById('card-errors').textContent = error.message;
    } else {
        if (paymentIntent.status === 'succeeded') {
            // Redirect to payment success route with the payment intent ID
            window.location.href = "{{ route('payment.success') }}?payment_intent=" + paymentIntent.id;
        } else {
            window.location.href = "{{ route('payment.failed') }}";
        }
    }
});

    </script>
</body>
</html>
