<x-app-layout>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <x-sidebar />

        <main class="flex justify-center items-center h-screen bg-gray-100">
            <div class="bg-white rounded-lg shadow-lg p-8 w-1/3 max-w-md mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Data</h2>
                    <button onclick="window.history.back();" class="text-gray-500 hover:text-gray-700">
                        <i class="fa fa-times text-lg"></i>
                    </button>
                </div>

                <form action="{{ route('data.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                        <input type="text" name="provinsi" id="provinsi" required placeholder="Masukkan nama provinsi"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#CEAB93] focus:border-transparent transition-all duration-300">
                    </div>

                    <div class="mb-4">
                        <label for="kab_kota" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                        <input type="text" name="kab_kota" id="kab_kota" required placeholder="Masukkan nama kabupaten/kota"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#CEAB93] focus:border-transparent transition-all duration-300">
                    </div>

                    <div class="mb-4">
                        <label for="presentase_pm" class="block text-sm font-medium text-gray-700">Persentase Penduduk Miskin (%)</label>
                        <input type="number" step="0.01" name="presentase_pm" id="presentase_pm" required
                            placeholder="Masukkan persentase penduduk miskin"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#CEAB93] focus:border-transparent transition-all duration-300">
                    </div>

                    <div class="mb-4">
                        <label for="pengeluaran_perkapita" class="block text-sm font-medium text-gray-700">Pengeluaran per Kapita (Rupiah)</label>
                        <input type="number" name="pengeluaran_perkapita" id="pengeluaran_perkapita" required
                            placeholder="Masukkan pengeluaran per kapita"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#CEAB93] focus:border-transparent transition-all duration-300">
                    </div>

                    <div class="mb-4">
                        <label for="tingkat_pengangguran" class="block text-sm font-medium text-gray-700">Tingkat Pengangguran Terbuka (%)</label>
                        <input type="number" step="0.01" name="tingkat_pengangguran" id="tingkat_pengangguran" required
                            placeholder="Masukkan tingkat pengangguran terbuka"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#CEAB93] focus:border-transparent transition-all duration-300">
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                            class="bg-[#CEAB93] text-white font-semibold px-6 py-3 rounded-md shadow-md hover:bg-[#d2b897] transition-colors duration-200">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    
</x-app-layout>
