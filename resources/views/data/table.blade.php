<style>
#editModal {
    z-index: 50;
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
}

#deleteModal {
    z-index: 9999;
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    /* Abu-abu dengan transparansi */
    display: flex;
    justify-content: center;
    align-items: center;
    transition: opacity 0.3s ease-in-out;
    /* Transisi halus */
}

#deleteModal.hidden {
    opacity: 0;
    pointer-events: none;
    /* Agar tidak bisa diinteraksi saat hidden */
}

.modal-content {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 20px;
    max-width: 500px;
    width: 100%;
    text-align: center;
    /* Untuk memusatkan teks di modal */
}

.modal-content .button-group {
    display: flex;
    justify-content: center;
    /* Menyelaraskan tombol secara horizontal */
    gap: 20px;
    /* Memberikan jarak antar tombol */
    margin-top: 20px;
    /* Memberikan jarak antara teks dan tombol */
}

.modal-content button {
    width: 100px;
    /* Ukuran lebar yang sama untuk kedua tombol */
    height: 40px;
    /* Ukuran tinggi yang sama */
    border-radius: 5px;
    /* Membuat tombol berbentuk rectangle dengan sudut membulat */
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
}

.modal-content button#cancelButton {
    background-color: #f3f3f3;
    color: #000;
    border: 1px solid #ccc;
    transition: all 0.2s ease-in-out;
}

.modal-content button#cancelButton:hover {
    background-color: #e0e0e0;
}

.modal-content button#deleteButton {
    background-color: #ff4d4d;
    color: white;
    border: none;
    transition: all 0.2s ease-in-out;
}

.modal-content button#deleteButton:hover {
    background-color: #ff1f1f;
}
</style>

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
                <th class="flexible-column">Tahun</th>
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
                <td class="flexible-column">{{ $item->tahun }}</td>
                <td class="flexible-column">{{ $item->klasifikasi_kemiskinan }}</td>
                <td class="flexible-column">
                    <!-- Tombol Edit -->
                    <button class="edit-button text-yellow-600 hover:underline" data-id="{{ $item->id_data }}"
                        data-provinsi="{{ $item->provinsi }}" data-kab_kota="{{ $item->kab_kota }}"
                        data-presentase_pm="{{ $item->presentase_pm }}"
                        data-pengeluaran_perkapita="{{ $item->pengeluaran_perkapita }}"
                        data-tingkat_pengangguran="{{ $item->tingkat_pengangguran }}" data-tahun="{{ $item->tahun }}"
                        data-klasifikasi_kemiskinan="{{ $item->klasifikasi_kemiskinan }}">
                        <i class="fa fa-edit"></i>
                    </button>

                    <!-- Form Hapus -->
                    <!-- <form action="{{ route('data.destroy', $item->id_data) }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline"
                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form> -->
                    <!-- Delete Button -->
                    <button type="button" class="delete-button text-red-600 hover:underline"
                        data-action="{{ route('data.destroy', $item->id_data) }}">
                        <i class="fa fa-trash"></i>
                    </button>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center text-gray-500 py-3">Tidak ada data yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal Edit -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 w-1/3 max-w-md">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit Data</h2>
                <button id="closeEditModalButton" class="text-gray-500 hover:text-gray-700">
                    <i class="fa fa-times text-lg"></i>
                </button>
            </div>
            <form id="editForm" action="{{ route('data.update', ':id') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_data" id="edit_id_data">
                <div class="mb-4">
                    <label for="edit_provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                    <input type="text" name="provinsi" id="edit_provinsi" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="edit_kab_kota" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                    <input type="text" name="kab_kota" id="edit_kab_kota" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="edit_presentase_pm" class="block text-sm font-medium text-gray-700">Persentase Penduduk
                        Miskin (%)</label>
                    <input type="number" name="presentase_pm" id="edit_presentase_pm" step="0.01" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="edit_pengeluaran_perkapita" class="block text-sm font-medium text-gray-700">Pengeluaran
                        per Kapita (Rupiah)</label>
                    <input type="number" name="pengeluaran_perkapita" id="edit_pengeluaran_perkapita" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="edit_tingkat_pengangguran" class="block text-sm font-medium text-gray-700">Tingkat
                        Pengangguran Terbuka (%)</label>
                    <input type="number" name="tingkat_pengangguran" id="edit_tingkat_pengangguran" step="0.01" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="edit_tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <input type="number" name="tahun" id="edit_tahun" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-[#CEAB93] text-white font-semibold px-6 py-3 rounded-md shadow-md hover:bg-[#d2b897] transition-colors duration-200">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Delete Confirmation Modal -->
    <!-- Modal Delete -->
    <div id="deleteModal" class="hidden">
        <div class="modal-content">
            <h2 class="text-lg font-bold mb-4 text-center">Yakin ingin menghapus data ini?</h2>
            <div class="button-group">
                <button id="cancelButton" class="px-4 py-2">Tidak</button>
                <form id="deleteForm" method="POST" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button id="deleteButton" type="submit" class="px-4 py-2">Ya</button>
                </form>
            </div>
        </div>

    </div>


    <!-- JavaScript -->
    <script>
    // Ambil semua tombol edit dan atur event listener
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', () => {
            // Ambil data dari atribut tombol
            const idData = button.getAttribute('data-id');
            const provinsi = button.getAttribute('data-provinsi');
            const kabKota = button.getAttribute('data-kab_kota');
            const presentasePm = button.getAttribute('data-presentase_pm');
            const pengeluaranPerkapita = button.getAttribute('data-pengeluaran_perkapita');
            const tingkatPengangguran = button.getAttribute('data-tingkat_pengangguran');
            const tahun = button.getAttribute('data-tahun');

            // Isi modal dengan data yang diambil
            document.getElementById('edit_id_data').value = idData;
            document.getElementById('edit_provinsi').value = provinsi;
            document.getElementById('edit_kab_kota').value = kabKota;
            document.getElementById('edit_presentase_pm').value = presentasePm;
            document.getElementById('edit_pengeluaran_perkapita').value = pengeluaranPerkapita;
            document.getElementById('edit_tingkat_pengangguran').value = tingkatPengangguran;
            document.getElementById('edit_tahun').value = tahun;

            // Atur action pada form
            const form = document.getElementById('editForm');
            form.action = form.action.replace(':id', idData);

            // Tampilkan modal
            document.getElementById('editModal').classList.remove('hidden');
        });
    });

    // Tutup modal
    document.getElementById('closeEditModalButton').addEventListener('click', () => {
        document.getElementById('editModal').classList.add('hidden');
    });

    document.addEventListener('DOMContentLoaded', () => {
        const deleteButtons = document.querySelectorAll('.delete-button');
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const cancelButton = document.getElementById('cancelButton');

        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const action = button.getAttribute('data-action');
                deleteForm.setAttribute('action', action);
                deleteModal.classList.remove('hidden');
            });
        });

        cancelButton.addEventListener('click', () => {
            deleteModal.classList.add('hidden');
        });
    });
    </script>
</div>