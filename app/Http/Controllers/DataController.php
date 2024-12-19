<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input provinsi dan pencarian
        $provinsi = $request->input('provinsi', 'all'); // Default 'all' jika tidak ada provinsi yang dipilih
        $query = $request->input('search');
    
        // Ambil data berdasarkan pencarian dan provinsi yang dipilih
        $data = Data::query()
            ->when($query, function ($q) use ($query) {
                $q->where('provinsi', 'like', "%{$query}%")
                    ->orWhere('kab_kota', 'like', "%{$query}%");
            })
            // Filter berdasarkan provinsi jika ada
            ->when($provinsi !== 'all', function ($q) use ($provinsi) {
                $q->where('provinsi', $provinsi);
            })
            // Urutkan berdasarkan provinsi secara ascending
            ->orderBy('provinsi', 'asc') // Mengurutkan berdasarkan provinsi
            ->get(); // Ambil semua data
    
        // Menghapus karakter BOM jika ada
        foreach ($data as $item) {
            $item->id_data = trim($item->id_data, "\xEF\xBB\xBF"); // Hapus BOM jika ada
        }
    
        $totalData = $data->count(); // Jumlah data yang ditampilkan
    
        // Hitung jumlah miskin dan tidak miskin dari semua data
        $jumlahMiskin = Data::where('klasifikasi_kemiskinan', 'Miskin')->count();
        $jumlahTidakMiskin = Data::where('klasifikasi_kemiskinan', 'Tidak Miskin')->count();
    
        // Jika permintaan adalah AJAX, hanya render tabel saja
        if ($request->ajax()) {
            return view('data.table', compact('data')); // Return the table view for paginated data
        }
    
        // Array Provinsi Indonesia
        $provinsiList = [
            'Aceh', 'Bali', 'Banten', 'Bengkulu', 'D I Yogyakarta', 'DKI Jakarta', 'Gorontalo', 'Jambi', 'Jawa Barat',
            'Jawa Tengah', 'Jawa Timur', 'Kalimantan Barat', 'Kalimantan Selatan', 'Kalimantan Tengah', 'Kalimantan Timur',
            'Kalimantan Utara', 'Kepulauan Riau', 'Lampung', 'Maluku', 'Maluku Utara', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Papua', 'Papua Barat', 'Riau', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tengah', 'Sulawesi Tenggara', 'Sulawesi Utara',
            'Sumatera Barat', 'Sumatera Selatan', 'Sumatera Utara', 'Bangka Belitung', 'Banten', 'Gorontalo', 'Jakarta', 'Jambi',
            'Kalimantan', 'Sulawesi', 'Papua', 'Nusa Tenggara', 'Maluku', 'Sumatra'
        ];
    
        return view('data.index', compact('data', 'provinsiList', 'provinsi', 'jumlahMiskin', 'jumlahTidakMiskin', 'totalData'));
    }
    

    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'provinsi' => 'required|string|max:100',
            'kab_kota' => 'required|string|max:100',
            'presentase_pm' => 'required|numeric',
            'pengeluaran_perkapita' => 'required|numeric',
            'tingkat_pengangguran' => 'required|numeric',
            'tahun' => 'required|numeric|digits:4'
        ]);

        // Ambil id_data terbaru dan buat id_data baru
        $lastData = Data::latest('id_data')->first();
        $nextId = $lastData ? intval(substr($lastData->id_data, 2)) + 1 : 1;
        $newId = 'DT' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Kirim Data ke Python API
        $response = Http::post('http://127.0.0.1:5000/predict', [ // Alamat API Python
            'presentase_pm' => $validated['presentase_pm'],
            'pengeluaran_perkapita' => $validated['pengeluaran_perkapita'],
            'tingkat_pengangguran' => $validated['tingkat_pengangguran'],
        ]);

        // Hasil Prediksi dari Python
        $predictedClass = $response->json()['klasifikasi_kemiskinan'];

        // Simpan Data ke Database
        $data = Data::create([
            'id_data' => $newId,
            'provinsi' => $validated['provinsi'],
            'kab_kota' => $validated['kab_kota'],
            'presentase_pm' => $validated['presentase_pm'],
            'pengeluaran_perkapita' => $validated['pengeluaran_perkapita'],
            'tingkat_pengangguran' => $validated['tingkat_pengangguran'],
            'tahun' => $validated['tahun'],
            'klasifikasi_kemiskinan' => $predictedClass, // Prediksi dari Python
        ]);

        return redirect()->route('data.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id_data)
    {
        // Ambil data berdasarkan ID, bukan seluruh koleksi
        $data = Data::findOrFail($id_data);
        return view('data.edit', compact('data'));
    }

    // Fungsi untuk menyimpan perubahan data
    public function update(Request $request, $id_data)
    {
        $data = Data::findOrFail($id_data);
        $data->provinsi = $request->input('provinsi');
        $data->kab_kota = $request->input('kab_kota');
        $data->presentase_pm = $request->input('presentase_pm');
        $data->pengeluaran_perkapita = $request->input('pengeluaran_perkapita');
        $data->tingkat_pengangguran = $request->input('tingkat_pengangguran');
        $data->tahun = $request->input('tahun');

        $data->save();
    
        return redirect()->route('data.index');
    }
    

    public function create()
    {
        $lastData = Data::latest('id_data')->first(); // Ambil data terakhir
        $nextId = $lastData ? intval(substr($lastData->id_data, 3)) + 1 : 1; // Ambil angka dari 'DTxxx' lalu tambahkan 1
        $newId = 'DT' . str_pad($nextId, 3, '0', STR_PAD_LEFT); // Format ulang jadi 'DTxxx'        

        return view('data.create', compact('newId'));
    }

    public function destroy($id_data)
    {
        $Data = Data::findOrFail($id_data);
        $Data->delete();

        return redirect()->route('data.index')->with('success', 'Data berhasil dihapus.');
    }

    public function show($id_data)
    {
        $data = Data::findOrFail($id_data);
        return view('data.show', compact('data'));
    }


}