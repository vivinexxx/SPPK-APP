<x-app-layout>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Konten Utama -->
        <main class="flex-1 flex flex-col items-center justify-start bg-gray-100 p-6 font-poppins">
            <!-- Judul Kelola Data -->
            <div class="w-full mb-3 flex justify-start text-5xl font-extrabold text-[#CEAB93]">
                Kelola Data
            </div>

            <!-- Tombol Tambah Data -->
            <div class="w-full mb-3 flex justify-start">
                <button class="bg-[#CEAB93] text-white font-bold px-4 py-2 rounded-md shadow-md hover:bg-[#d2b897]"
                    onclick="window.location.href='{{ route('data.create') }}'">
                    Tambah Data
                </button>
            </div>

            <!-- Statistik & Pencarian -->
            <div class="w-full flex justify-between items-center mb-4">
                <!-- Statistik -->
                <div>
                    <strong>Jumlah Miskin:</strong> {{ $jumlahMiskin }} <br>
                    <strong>Jumlah Tidak Miskin:</strong> {{ $jumlahTidakMiskin }}
                </div>
                <!-- Pencarian -->
                <div class="relative w-1/3">
                    <form action="{{ route('data.index') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="border border-gray-300 rounded-md px-4 py-2 w-full pr-10 focus:outline-none focus:ring focus:ring-[#CEAB93]"
                            placeholder="Cari daerah..." />
                        <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Navigation Arrows -->
            <div class="w-full mb-4 flex items-center justify-between">
                <button class="bg-gray-200 p-2 rounded-full shadow-md hover:bg-gray-300" onclick="previousPage()">
                    <i class="fa fa-arrow-left"></i>
                </button>
                <span class="text-gray-600">Tampilkan halaman</span>
                <button class="bg-gray-200 p-2 rounded-full shadow-md hover:bg-gray-300" onclick="nextPage()">
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>

            <!-- Tabel Data -->
            <div class="w-full">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-300 px-2 py-1">No.</th>
                            <th class="border border-gray-300 px-2 py-1">Provinsi</th>
                            <th class="border border-gray-300 px-2 py-1">Kab/Kota</th>
                            <th class="border border-gray-300 px-2 py-1">Persentase Penduduk Miskin (%)</th>
                            <th class="border border-gray-300 px-2 py-1">Pengeluaran per Kapita</th>
                            <th class="border border-gray-300 px-2 py-1">Tingkat Pengangguran Terbuka</th>
                            <th class="border border-gray-300 px-2 py-1">Klasifikasi Kemiskinan</th>
                            <th class="border border-gray-300 px-2 py-1">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $item)
                            <tr>
                                <td class="border border-gray-300 px-2 py-1">{{ $key + 1 }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $item->provinsi }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $item->kab_kota }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $item->presentase_pm }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $item->pengeluaran_perkapita }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $item->tingkat_pengangguran }}</td>
                                <td class="border border-gray-300 px-2 py-1">{{ $item->klasifikasi_kemiskinan }}</td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('data.edit', $item->id_data) }}"
                                        class="text-yellow-600 hover:underline">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('data.destroy', $item->id_data) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Script untuk Navigasi Halaman -->
    <script>
        function previousPage() {
            console.log('Navigasi ke halaman sebelumnya');
            // Implementasi navigasi ke halaman sebelumnya
        }

        function nextPage() {
            console.log('Navigasi ke halaman berikutnya');
            // Implementasi navigasi ke halaman berikutnya
        }
    </script>
</x-app-layout>