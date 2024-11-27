<x-guest-layout>
    <div class="min-h-screen flex justify-center items-center ">
        <div class="flex max-w-4xl w-full p-8 bg-white rounded-lg shadow-xl">
            <!-- Login Form Section -->
            <div class="w-1/2 p-6 space-y-6">
                <h2 class="text-3xl font-bold text-gray-900">Log In</h2>
                <p class="text-sm text-gray-500 mb-6">Immerse yourself in a hassle-free login journey with our intuitively designed login form. Effortlessly access your account.</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full p-2 border border-gray-300 rounded-md" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter email" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full p-2 border border-gray-300 rounded-md" type="password" name="password" required autocomplete="current-password" placeholder="Enter password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4 flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <label for="remember_me" class="ml-2 text-sm text-gray-600">Remember me</label>
                    </div>

                    <!-- Forgot Password Link -->
                    <div class="mt-4">
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-900">Forgot your password?</a>
                    </div>

                    <!-- Login Button -->
                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="w-full bg-gradient-to-r from-blue-500 to-teal-400 text-white font-semibold py-2 px-4 rounded-md hover:from-blue-600 hover:to-teal-500 transition duration-300">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>

                    <!-- Register Link -->
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">Don't have an account? <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-900">Register here</a></p>
                    </div>
                </form>
            </div>

            <!-- Background Image Section -->
            <div class="hidden md:block md:w-1/2 relative">
                <img src="{{ asset('images/shopping-cart.jpg') }}" alt="background image" class="w-full h-full object-cover rounded-lg">
                <div class="absolute inset-0 bg-gradient-to-l from-transparent to-blue-500 opacity-40"></div>
            </div>
        </div>
    </div>
</x-guest-layout>
