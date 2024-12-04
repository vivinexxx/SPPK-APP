<x-guest-layout>
    <!-- Container Utama -->
    <div class="flex items-center justify-center">
        <div class=" max-w-sm p-6 rounded-lg">
            <h2 class="text-2xl font-bold text-center mb-4">Masuk</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="sr-only">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa fa-user text-gray-400"></i>
                        </span>
                        <x-text-input id="email" class="w-full pl-10 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-yellow-200" 
                                      type="email" name="email" :value="old('email')" placeholder="Email" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="sr-only">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa fa-lock text-gray-400"></i>
                        </span>
                        <x-text-input id="password" class="w-full pl-10 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-yellow-200" 
                                      type="password" name="password" placeholder="Kata sandi" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="block mb-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" 
                               class="rounded border-gray-300 text-yellow-600 shadow-sm focus:ring-yellow-500" 
                               name="remember">
                        <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                </div>

                <!-- Tombol Login -->
                <div>
                    <button type="submit"
                        class="w-full p-2 text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition duration-300"
                        style="background-color: #E3CAA5; hover:bg-[#d3b995]; transition: 300ms;">
                        Masuk
                    </button>
                </div>
            </form>

            <!-- Link ke Registrasi -->
            <p class="mt-4 text-sm text-center text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-[#E3CAA5] hover:underline">Daftar, yuk!</a>
            </p>
        </div>
    </div>
</x-guest-layout>
