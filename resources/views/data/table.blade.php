<div class="table-container">
    <!-- Tabel Data -->
    <table class="table-auto w-full border border-gray-300">
        <thead>
            <tr>
                <th class="flexible-column">No.</th>
                <th class="provinsi-column">Provinsi</th>
                <th class="kabkota-column">Kab/Kota</th>
                <th class="flexible-column">Persentase Penduduk Miskin (%)</th>
                <th class="flexible-column">Pengeluaran per Kapita</th>
                <th class="flexible-column">Tingkat Pengangguran Terbuka</th>
                <th class="flexible-column">Klasifikasi Kemiskinan</th>
                <th class="flexible-column">Aksi</th>
            </tr>
        </thead>
        <tbody id="data-table">
            <!-- Loop Data -->
            @forelse ($data as $key => $item)
                <tr>
                    <td class="flexible-column">{{ $key + 1 }}</td>
                    <td class="provinsi-column">{{ $item->provinsi }}</td>
                    <td class="kabkota-column">{{ $item->kab_kota }}</td>
                    <td class="flexible-column">{{ $item->presentase_pm }}</td>
                    <td class="flexible-column">{{ $item->pengeluaran_perkapita }}</td>
                    <td class="flexible-column">{{ $item->tingkat_pengangguran }}</td>
                    <td class="flexible-column">{{ $item->klasifikasi_kemiskinan }}</td>
                    <td class="flexible-column">
                        <!-- Tombol Edit -->
                        <a href="{{ route('data.edit', $item->id_data) }}" class="text-yellow-600 hover:underline">
                            <i class="fa fa-edit"></i>
                        </a>

                        <!-- Form Hapus -->
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
            @empty
                <!-- Jika Tidak Ada Data -->
                <tr>
                    <td colspan="8" class="text-center text-gray-500 py-3">
                        Tidak ada data yang ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>


    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg w-96 p-6 shadow-lg">
            <div class="flex justify-between items-center border-b pb-2">
                <h2 class="text-xl font-bold text-gray-700">Edit Data</h2>
                <button id="closeModal" class="text-gray-400 hover:text-gray-700">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <form id="editForm" action="" method="POST" class="mt-4">
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="mb-4">
                    <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                    <input type="text" id="provinsi" name="provinsi"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="mb-4">
                    <label for="kab_kota" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                    <input type="text" id="kab_kota" name="kab_kota"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="mb-4">
                    <label for="presentase_pm" class="block text-sm font-medium text-gray-700">Presentase Penduduk
                        Miskin (%)</label>
                    <input type="number" step="0.01" id="presentase_pm" name="presentase_pm"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="mb-4">
                    <label for="pengeluaran_perkapita" class="block text-sm font-medium text-gray-700">Pengeluaran per
                        Kapita</label>
                    <input type="number" id="pengeluaran_perkapita" name="pengeluaran_perkapita"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="mb-4">
                    <label for="tingkat_pengangguran" class="block text-sm font-medium text-gray-700">Tingkat
                        Pengangguran Terbuka (%)</label>
                    <input type="number" step="0.01" id="tingkat_pengangguran" name="tingkat_pengangguran"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="flex justify-end">
                    <button type="button" id="cancelModal"
                        class="mr-2 px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>


</div>

<!-- JavaScript -->
<script>
    document.querySelectorAll('.fa-edit').forEach(button => {
        button.addEventListener('click', () => {
            const modal = document.getElementById('editModal');
            modal.classList.remove('hidden');
        });
    });

    document.getElementById('closeModal').addEventListener('click', () => {
        const modal = document.getElementById('editModal');
        modal.classList.add('hidden');
    });

    document.getElementById('cancelModal').addEventListener('click', () => {
        const modal = document.getElementById('editModal');
        modal.classList.add('hidden');
    });
</script>