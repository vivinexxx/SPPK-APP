<x-guest-layout>
    <!-- Container Utama -->
    <div class="flex items-center justify-center">
        <div class="w-full max-w-sm p-6 bg-white">
            <h2 class="text-2xl font-bold text-center mb-4">Daftar</h2>

            <!-- Form Register -->
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="sr-only">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa fa-user text-gray-400"></i>
                        </span>
                        <x-text-input id="name" class="w-full pl-10 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-[#E3CAA5]" 
                                      type="text" name="name" :value="old('name')" placeholder="Nama lengkap" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                </div>

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="sr-only">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa fa-envelope text-gray-400"></i>
                        </span>
                        <x-text-input id="email" class="w-full pl-10 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-[#E3CAA5]" 
                                      type="email" name="email" :value="old('email')" placeholder="Email" required />
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
                        <x-text-input id="password" class="w-full pl-10 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-[#E3CAA5]" 
                                      type="password" name="password" placeholder="Kata sandi" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="sr-only">Konfirmasi Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <i class="fa fa-lock text-gray-400"></i>
                        </span>
                        <x-text-input id="password_confirmation" class="w-full pl-10 p-2 border rounded-lg focus:outline-none focus:ring focus:ring-[#E3CAA5]" 
                                      type="password" name="password_confirmation" placeholder="Konfirmasi kata sandi" required />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                </div>

                <!-- Tombol Register -->
                <div>
                    <button type="submit"
                        class="w-full p-2 text-white rounded-lg"
                        style="background-color: #E3CAA5; hover:bg-[#d3b995]; transition: 300ms;">
                        Daftar
                    </button>
                </div>
            </form>

            <!-- Link ke Login -->
            <p class="mt-4 text-sm text-center text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-[#E3CAA5] hover:underline">Masuk di sini</a>
            </p>
        </div>
    </div>
</x-guest-layout>
