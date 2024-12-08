<div class="table-container">
    <!-- Pagination -->
    @if ($data instanceof \Illuminate\Pagination\Paginator || $data instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="pagination-container mt-4">
            {{ $data->appends(request()->input())->links('pagination::tailwind') }}
        </div>
    @endif

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
                        <a href="{{ route('data.edit', $item->id_data) }}" class="text-yellow-600 hover:underline">
                            <i class="fa fa-edit"></i>
                        </a>
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
                <tr>
                    <td colspan="8" class="text-center text-gray-500 py-3">
                        Tidak ada data yang ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
</div>