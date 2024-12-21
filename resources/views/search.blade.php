<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <x-sidebar class="h-full" />

        <!-- Main Content -->
        <main class="flex-1 flex flex-col bg-white p-8 font-poppins">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-4xl font-bold text-[#CEAB93]">Lihat Keputusan</h1>
                <h2 class="text-lg text-gray-600">Tingkat Kemiskinan di Daerah Indonesia</h2>
            </div>

            <!-- Search Form -->
            <form id="searchForm" action="{{ route('search.result') }}" method="POST" class="w-full max-w-md mx-auto">
                @csrf
                <div class="mb-4">
                    <label for="regionSelect" class="block text-gray-700 font-medium mb-2">Cari daerah yang ingin
                        dilihat</label>
                    <select id="regionSelect" name="region" class="w-full border border-gray-300 rounded-md px-4 py-2">
                        <option value="">Pilih wilayah...</option>
                        @foreach ($regions as $region)
                            <option value="{{ \Str::slug($region->provinsi . '_' . $region->kab_kota, '_') }}">
                                {{ $region->provinsi }}, {{ $region->kab_kota }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="button" id="openModalButton"
                    class="w-full bg-[#CEAB93] text-white font-medium px-4 py-2 rounded-md hover:bg-[#b2917c]">
                    Cari Keputusan
                </button>
            </form>
        </main>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white rounded-lg shadow-lg w-3/4 max-h-[90vh] overflow-y-auto p-6 relative">
            <!-- Close Button -->
            <button onclick="closeModal()"
                class="absolute top-4 right-4 text-red-500 text-2xl font-bold bg-gray-100 hover:bg-gray-200 rounded-full w-8 h-8 flex items-center justify-center">
                &times;
            </button>

            <!-- Modal Content -->
            <div>
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-4xl font-bold text-[#CEAB93]">Lihat Keputusan</h1>
                    <h2 class="text-lg text-gray-600">Tingkat Kemiskinan di Daerah Indonesia</h2>
                </div>

                <!-- Decision Content -->
                <div class="bg-gray-100 rounded-lg p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Keputusan</h2>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="font-medium">Presentase penduduk miskin</p>
                            <div class="relative bg-gray-200 rounded-full h-4 mt-2">
                                <div class="absolute bg-red-500 h-4 rounded-full" style="width: 11.3%;"></div>
                            </div>
                            <p class="text-gray-600 mt-1">11,3%</p>
                        </div>
                        <div>
                            <p class="font-medium">Pengeluaran Perkapita</p>
                            <div class="relative bg-gray-200 rounded-full h-4 mt-2">
                                <div class="absolute bg-blue-500 h-4 rounded-full" style="width: 57%;"></div>
                            </div>
                            <p class="text-gray-600 mt-1">8546</p>
                        </div>
                        <div>
                            <p class="font-medium">Tingkat pengangguran terbuka</p>
                            <div class="relative bg-gray-200 rounded-full h-4 mt-2">
                                <div class="absolute bg-green-500 h-4 rounded-full" style="width: 11.65%;"></div>
                            </div>
                            <p class="text-gray-600 mt-1">11,65%</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-gray-700">Menghasilkan sebuah keputusan yaitu:</h3>
                        <p class="mt-2">Nama Provinsi: <span class="font-medium">Jawa Barat</span></p>
                        <p>Nama Kabupaten/Kota: <span class="font-medium">Bandung</span></p>
                        <p>Status: <span class="font-medium">Miskin</span></p>
                        <p>Keputusan: <span class="font-medium">Dana difokuskan bansos</span></p>
                        <p>Tanggal analisa: <span class="font-medium">12-10-2024</span></p>
                    </div>
                </div>

                <!-- Historical Table -->
                <div class="mt-8">
                    <table class="w-full border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border border-gray-300 px-4 py-2">Tahun</th>
                                <th class="border border-gray-300 px-4 py-2">Provinsi</th>
                                <th class="border border-gray-300 px-4 py-2">Kab/Kota</th>
                                <th class="border border-gray-300 px-4 py-2">Presentase Penduduk Miskin</th>
                                <th class="border border-gray-300 px-4 py-2">Pengeluaran Perkapita</th>
                                <th class="border border-gray-300 px-4 py-2">Tingkat Pengangguran</th>
                                <th class="border border-gray-300 px-4 py-2">Status</th>
                                <th class="border border-gray-300 px-4 py-2">Keputusan</th>
                            </tr>
                        </thead>
                        <tbody id="historicalTable">
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">2024</td>
                                <td class="border border-gray-300 px-4 py-2">Jawa Barat</td>
                                <td class="border border-gray-300 px-4 py-2">Bandung</td>
                                <td class="border border-gray-300 px-4 py-2">11,3%</td>
                                <td class="border border-gray-300 px-4 py-2">8546</td>
                                <td class="border border-gray-300 px-4 py-2">11,65%</td>
                                <td class="border border-gray-300 px-4 py-2">Miskin</td>
                                <td class="border border-gray-300 px-4 py-2">Dana difokuskan Bansos</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById("modal");
        const openModalButton = document.getElementById("openModalButton");
        const regionSelect = document.getElementById("regionSelect");

        openModalButton.addEventListener("click", () => {
            if (regionSelect.value) {
                modal.classList.remove("hidden");
            } else {
                alert("Silakan pilih wilayah terlebih dahulu.");
            }
        });

        function closeModal() {
            modal.classList.add("hidden");
        }
    </script>
</x-app-layout>
