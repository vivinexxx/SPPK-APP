<style>
    /* Menambahkan scroll khusus untuk tabel */
    .table-container {
        max-height: 400px;
        /* Sesuaikan tinggi maksimal tabel sesuai kebutuhan */
        overflow-y: auto;
        /* Hanya scroll tabel vertikal */
        position: relative;
        /* Membuat container menjadi posisi relatif */
    }

    /* Memastikan header tabel tetap terlihat */
    table thead th {
        position: sticky;
        top: 0;
        /* Menjaga posisi header tetap di atas saat di-scroll */
        background-color: #f3f4f6;
        /* Warna latar belakang header */
        z-index: 1;
        /* Pastikan header berada di atas konten tabel */
    }

    th,
    td {
        text-align: left;
        padding: 8px;
        border: 1px solid #ddd;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    th {
        font-weight: bold;
    }

    td {
        background-color: #fff;
    }

    /* Jika Anda ingin mengatur tinggi sidebar agar tetap di tempat */
    .x-sidebar {
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
        background-color: #f8f9fa;
    }

    /* Konten utama */
    main {
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        height: 100vh;
    }

    /* Tata letak tabel */
    table {
        width: 100%;
        table-layout: fixed;
        /* Lebar kolom tetap */
        border-collapse: collapse;
        margin-top: 10px;
    }

    /* Gaya tambahan untuk pencarian */
    #search-bar {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .loading-spinner {
        display: none;
        text-align: center;
        font-size: 14px;
        color: gray;
    }
</style>

<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <x-sidebar class="h-full" />

        <!-- Konten Utama -->
        <main class="flex-1 flex flex-col bg-gray-100 p-4 font-poppins">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="text-4xl font-extrabold text-[#CEAB93]">Kelola Data</h1>
            </div>

            <!-- Tombol Tambah Data -->
            <div class="mb-4">
                <button id="openModalButton"
                    class="bg-[#CEAB93] text-white font-bold px-4 py-2 rounded-md shadow-md hover:bg-[#d2b897]">
                    Tambah Data
                </button>
            </div>

            <!-- Statistik dan Pencarian -->
            <div class="flex justify-between items-center mb-4">
                <!-- Statistik -->
                <div>
                    <strong>Jumlah Miskin:</strong> {{ $jumlahMiskin }} <br>
                    <strong>Jumlah Tidak Miskin:</strong> {{ $jumlahTidakMiskin }}
                </div>

                <!-- Search Bar -->
                <div class="relative w-1/3">
                    <input type="text" id="search-bar" placeholder="Cari daerah..."
                        class="border border-gray-300 rounded-md px-4 py-2 w-full focus:outline-none focus:ring focus:ring-[#CEAB93]" />
                </div>
            </div>

            <!-- Loading Spinner -->
            <div id="loading-spinner" class="loading-spinner">Memuat data...</div>


            <div class="w-full flex justify-between items-center mb-4">
                <!-- Dropdown untuk baris per halaman -->
                <div>
                    <label for="rows-per-page" class="text-gray-600">Tampilkan</label>
                    <select id="rows-per-page"
                        class="border border-gray-300 rounded-md px-2 py-1 focus:outline-none focus:ring focus:ring-[#CEAB93] w-60"
                        onchange="updateRowsPerPage()">
                        <option value="5" {{ request()->input('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request()->input('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request()->input('per_page') == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ request()->input('per_page') == 50 ? 'selected' : '' }}>50</option>
                        <option value="all" {{ request()->input('per_page') == 'all' ? 'selected' : '' }}>Tampilkan Semua
                        </option>
                    </select>
                    <span class="text-gray-600">baris</span>
                </div>
            </div>

            <!-- Modal -->
            <div id="modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
                <div class="bg-white rounded-lg shadow-lg p-8 w-1/3 max-w-md">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Tambah Data</h2>
                        <button id="closeModalButton" class="text-gray-500 hover:text-gray-700">
                            <i class="fa fa-times text-lg"></i>
                        </button>
                    </div>
                    <form action="{{ route('data.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="provinsi" class="block text-sm font-medium text-gray-700">Provinsi</label>
                            <input type="text" name="provinsi" id="provinsi" required
                                placeholder="Masukkan nama provinsi"
                                class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#CEAB93] focus:border-transparent transition-all duration-300">
                        </div>

                        <div class="mb-4">
                            <label for="kab_kota" class="block text-sm font-medium text-gray-700">Kabupaten/Kota</label>
                            <input type="text" name="kab_kota" id="kab_kota" required
                                placeholder="Masukkan nama kabupaten/kota"
                                class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#CEAB93] focus:border-transparent transition-all duration-300">
                        </div>

                        <div class="mb-4">
                            <label for="presentase_pm" class="block text-sm font-medium text-gray-700">Persentase
                                Penduduk Miskin (%)</label>
                            <input type="number" step="0.01" name="presentase_pm" id="presentase_pm" required
                                placeholder="Masukkan persentase penduduk miskin"
                                class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#CEAB93] focus:border-transparent transition-all duration-300">
                        </div>

                        <div class="mb-4">
                            <label for="pengeluaran_perkapita"
                                class="block text-sm font-medium text-gray-700">Pengeluaran per Kapita (Rupiah)</label>
                            <input type="number" name="pengeluaran_perkapita" id="pengeluaran_perkapita" required
                                placeholder="Masukkan pengeluaran per kapita"
                                class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[#CEAB93] focus:border-transparent transition-all duration-300">
                        </div>

                        <div class="mb-4">
                            <label for="tingkat_pengangguran" class="block text-sm font-medium text-gray-700">Tingkat
                                Pengangguran Terbuka (%)</label>
                            <input type="number" step="0.01" name="tingkat_pengangguran" id="tingkat_pengangguran"
                                required placeholder="Masukkan tingkat pengangguran terbuka"
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
            </div>

            <!-- Tabel Data -->
            <div class="overflow-x-auto table-container">
                @include('data.table', ['data' => $data])
            </div>

        </main>
    </div>

    <script>
        function updateRowsPerPage() {
            const perPage = document.getElementById('rows-per-page').value;
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', perPage);
            window.location.href = url.toString();
        }
    </script>


    <script>
        const openModalButton = document.getElementById('openModalButton');
        const closeModalButton = document.getElementById('closeModalButton');
        const modal = document.getElementById('modal');

        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });

        closeModalButton.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
            }
        });
    </script>

    <script>
        document.getElementById('search-bar').addEventListener('input', function () {
            const query = this.value;
            const spinner = document.getElementById('loading-spinner');

            // Tampilkan spinner
            spinner.style.display = 'block';

            fetch("{{ route('data.index') }}?search=" + query, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const updatedTable = doc.querySelector('tbody#data-table');

                    // Update hanya isi tabel
                    document.querySelector('tbody#data-table').replaceWith(updatedTable);

                    // Sembunyikan spinner
                    spinner.style.display = 'none';
                })
                .catch(error => {
                    console.error('Error:', error);
                    spinner.style.display = 'none';
                });
        });
    </script>

    <script>
        document.getElementById('rows-per-page').addEventListener('change', function () {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', this.value);
            window.location.href = url.toString();
        });
    </script>

    <script>
        document.getElementById('search-bar').addEventListener('input', function () {
            const query = this.value;
            const spinner = document.getElementById('loading-spinner');

            // Tampilkan spinner
            spinner.style.display = 'block';

            const perPage = document.getElementById('rows-per-page').value; // Ambil nilai per page yang terpilih
            const url = new URL(window.location.href);
            url.searchParams.set('search', query); // Tambahkan parameter search
            url.searchParams.set('per_page', perPage); // Tambahkan parameter per_page

            fetch(url.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const updatedTable = doc.querySelector('tbody#data-table');

                    // Update hanya isi tabel
                    document.querySelector('tbody#data-table').replaceWith(updatedTable);

                    // Sembunyikan spinner
                    spinner.style.display = 'none';
                })
                .catch(error => {
                    console.error('Error:', error);
                    spinner.style.display = 'none';
                });
        });

    </script>
</x-app-layout>