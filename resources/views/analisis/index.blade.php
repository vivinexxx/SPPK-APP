<x-app-layout>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <x-sidebar class="h-full" />

        <!-- Konten Utama -->
        <main class="flex-1 flex flex-col bg-gray-100 p-4 font-poppins">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="text-4xl font-extrabold text-[#CEAB93]">Analisis</h1>
                <h3>Tingkat Kemiskinan Daerah di Indonesia</h3>
            </div>

            <div class="flex justify-between items-center mb-4">
                <!-- Tombol Cari -->
                <div id="openModalButton"
                    class="bg-[#ffffff] border border-gray-300 text-gray font-medium px-4 py-2 rounded-md shadow-md hover:bg-[#DCDCDC] relative w-1/4">
                    <button>Cari Keputusan</button>
                </div>

                <!-- Dropdown -->
                <div class="relative w-1/4">
                    <select id="provinsi" name="provinsi" class="border border-gray-300 rounded-md px-4 py-2 w-full">
                        <option value="Semua" {{ $provinsi == 'Semua' ? 'selected' : '' }}>Semua</option>
                        @foreach($provinsiList as $prov)
                        <option value="{{ $prov }}" {{ $provinsi == $prov ? 'selected' : '' }}>{{ $prov }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Pie chart -->
            <div class="flex justify-center">
                <canvas id="pieChart" width="400" height="400"></canvas>
            </div>

            <!-- Memuat Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



            <script>
            // Fungsi untuk mengupdate chart dengan data baru
            function updateChart(jumlahTidakMiskin, jumlahMiskin) {
                const ctx = document.getElementById('pieChart').getContext('2d');
                if (window.chart) {
                    window.chart.destroy(); // Hapus chart lama
                }

                window.chart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: ['Tidak Miskin', 'Miskin'],
                        datasets: [{
                            label: 'Persentase Kemiskinan',
                            data: [jumlahTidakMiskin, jumlahMiskin],
                            backgroundColor: ['#2470AF', '#D91B41'],
                            borderColor: ['#fff', '#fff'],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'left',
                                align: 'bottom',
                                labels: {
                                    boxWidth: 20,
                                    boxHeight: 20,
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw + ' Daerah';
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Event listener untuk dropdown
            $('#provinsi').on('change', function() {
                var provinsi = $(this).val();
                console.log("Provinsi terpilih:", provinsi); // Debugging

                if (provinsi) {
                    $.ajax({
                        url: "{{ route('analisis.index') }}",
                        type: 'GET',
                        data: {
                            provinsi: provinsi
                        },
                        success: function(response) {
                            console.log(response); // Debugging respons server
                            const tidakMiskin = response.jumlahTidakMiskin || 0;
                            const miskin = response.jumlahMiskin || 0;
                            updateChart(tidakMiskin, miskin);
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", error); // Debugging jika AJAX gagal
                        }
                    });
                }
            });

            // Initial chart dengan data default
            window.onload = function() {
                updateChart(
                    @json($jumlahTidakMiskin),
                    @json($jumlahMiskin)
                );
            };
            </script>

        </main>
    </div>

</x-app-layout>