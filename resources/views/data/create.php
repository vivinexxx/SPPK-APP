<x-app-layout>
<div class="flex h-screen">
        <!-- Sidebar -->
        <x-sidebar />
    <main class="flex justify-center items-center h-screen bg-gray-100">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Tambah Data</h2>
                <button onclick="window.history.back();" class="text-gray-500 hover:text-gray-700">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <form action="{{ route('data.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                    <input type="text" name="provinsi" id="provinsi" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-[#CEAB93]">
                </div>
                <div class="mb-4">
                    <label for="kab_kota" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                    <input type="text" name="kab_kota" id="kab_kota" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-[#CEAB93]">
                </div>
                <div class="mb-4">
                    <label for="presentase_pm" class="block text-sm font-medium text-gray-700">Persentase Penduduk Miskin (%)</label>
                    <input type="number" step="0.01" name="presentase_pm" id="presentase_pm" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-[#CEAB93]">
                </div>
                <div class="mb-4">
                    <label for="pengeluaran_perkapita" class="block text-sm font-medium text-gray-700">Pengeluaran per Kapita (Rupiah)</label>
                    <input type="number" name="pengeluaran_perkapita" id="pengeluaran_perkapita" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-[#CEAB93]">
                </div>
                <div class="mb-4">
                    <label for="tingkat_pengangguran" class="block text-sm font-medium text-gray-700">Tingkat Pengangguran Terbuka (%)</label>
                    <input type="number" step="0.01" name="tingkat_pengangguran" id="tingkat_pengangguran" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-[#CEAB93]">
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="bg-[#CEAB93] text-white font-bold px-4 py-2 rounded-md shadow-md hover:bg-[#d2b897]">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </m>
</x-app-layout>
