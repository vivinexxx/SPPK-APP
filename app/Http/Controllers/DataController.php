<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;
use Illuminate\Support\Facades\Http;

class DataController extends Controller

{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $perPage = $request->input('per_page', 10); // Default 10 baris per halaman
        $page = $request->input('page', 1); // Halaman yang aktif, default 1
        
        // Jika pengguna memilih "Tampilkan Semua"
        if ($perPage == 'all') {
            $data = Data::query()
                ->when($query, function ($q) use ($query) {
                    $q->where('provinsi', 'like', "%{$query}%")
                        ->orWhere('kab_kota', 'like', "%{$query}%");
                })
                ->orderBy('provinsi', 'asc') // Urutkan berdasarkan provinsi
                ->get(); // Ambil semua data
            $totalData = $data->count(); // Jumlah data yang ditampilkan
            $totalPages = 1; // Jika semua data ditampilkan, hanya ada 1 halaman
        } else {
            // Hitung total data
            $totalData = Data::query()
                ->when($query, function ($q) use ($query) {
                    $q->where('provinsi', 'like', "%{$query}%")
                        ->orWhere('kab_kota', 'like', "%{$query}%");
                })
                ->count();
    
            // Hitung offset dan data yang diambil berdasarkan halaman
            $offset = ($page - 1) * $perPage;
            $data = Data::query()
                ->when($query, function ($q) use ($query) {
                    $q->where('provinsi', 'like', "%{$query}%")
                        ->orWhere('kab_kota', 'like', "%{$query}%");
                })
                ->orderBy('provinsi', 'asc') // Urutkan berdasarkan provinsi
                ->skip($offset)  // Mengambil data sesuai halaman
                ->take($perPage) // Ambil sejumlah data sesuai per_page
                ->get();
    
            // Menghitung total halaman
            $totalPages = ceil($totalData / $perPage);
        }
        
        // Hitung jumlah miskin dan tidak miskin dari semua data
        $jumlahMiskin = Data::where('klasifikasi_kemiskinan', 'Miskin')->count();
        $jumlahTidakMiskin = Data::where('klasifikasi_kemiskinan', 'Tidak Miskin')->count();
        
        // Jika permintaan adalah AJAX, hanya render tabel saja
        if ($request->ajax()) {
            return view('data.table', compact('data')); // For paginated data
        }
        
        // Kirim variabel jumlah miskin dan tidak miskin, serta info paginasi ke tampilan
        return view('data.index', compact('data', 'jumlahMiskin', 'jumlahTidakMiskin', 'totalData', 'totalPages', 'perPage', 'page'));
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
        // Validasi Input
        $validated = $request->validate([
            'provinsi' => 'required|string|max:100',
            'kab_kota' => 'required|string|max:100',
            'presentase_pm' => 'required|numeric',
            'pengeluaran_perkapita' => 'required|numeric',
            'tingkat_pengangguran' => 'required|numeric',
        ]);

        // Ambil data berdasarkan ID, bukan seluruh koleksi
        $data = Data::findOrFail($id_data);

        // Update hanya kolom yang bisa diedit
        $data->provinsi = $request->input('provinsi');
        $data->kab_kota = $request->input('kab_kota');
        $data->presentase_pm = $request->input('presentase_pm');
        $data->pengeluaran_perkapita = $request->input('pengeluaran_perkapita');
        $data->tingkat_pengangguran = $request->input('tingkat_pengangguran');

        // Simpan perubahan
        $data->save();

        // Redirect dengan pesan sukses
        return redirect()->route('data.index')->with('success', 'Data berhasil diperbarui.');
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

}