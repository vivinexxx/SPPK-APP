<x-app-layout>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Konten Utama -->
        <main class="flex-1 flex items-center justify-center bg-gray-100">
            <div class="bg-[#AD8B73] text-white p-8 rounded-md shadow-md max-w-4xl flex items-center">
                <!-- Konten Teks -->
                <div>
                    <h1 class="text-5xl font-bold">Selamat Datang,</h1> 
                        <h1 class="text-5xl font-bold">{{ Auth::user()->name }}</h1>
                    <p class="mt-4 text-xl">
                        di Sistem Pengambilan Keputusan Kebijakan Bantuan Daerah Berdasarkan Status Kemiskinan
                    </p>
                </div>
                <!-- Gambar di samping teks -->
                <img src="{{ asset('image/image 2.png') }}" alt="Dashboard Illustration"
                    class="w-75 h-22l mr-4">


            </div>
        </main>
    </div>
</x-app-layout>