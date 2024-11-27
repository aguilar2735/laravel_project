<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-200 via-green-200 to-blue-200">
        <!-- Main Container -->
        <div class="flex w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden">
            <!-- Left Side: Background Image -->
            <div class="hidden md:block md:w-1/2 relative">
                <img src="{{ asset('images/shopping-cart.jpg') }}" alt="Background Image" 
                     class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-l from-transparent to-blue-500 opacity-40"></div>
            </div>

            <!-- Right Side: Registration Form -->
            <div class="w-full md:w-1/2 p-8 space-y-6">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Register</h2>
                    <p class="text-gray-600 text-sm">
                        Create an account to explore new possibilities with our platform.
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-teal-400 text-white font-semibold py-2 px-4 rounded-md hover:from-blue-600 hover:to-teal-500 transition duration-300">
                            Register
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-600">
                        Already have an account? <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:underline">Log In</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
