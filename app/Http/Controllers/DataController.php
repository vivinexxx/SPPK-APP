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

        // Ambil semua data tanpa paginasi
        $data = Data::query()
            ->when($query, function ($q) use ($query) {
                $q->where('provinsi', 'like', "%{$query}%")
                    ->orWhere('kab_kota', 'like', "%{$query}%");
            })
            ->orderBy('provinsi', 'asc') // Urutkan berdasarkan provinsi
            ->get(); // Ambil semua data

        // Hitung jumlah miskin dan tidak miskin dari semua data
        $jumlahMiskin = Data::where('klasifikasi_kemiskinan', 'Miskin')->count();
        $jumlahTidakMiskin = Data::where('klasifikasi_kemiskinan', 'Tidak Miskin')->count();

        // Kirim variabel jumlah miskin dan tidak miskin ke tampilan
        return view('data.index', compact('data', 'jumlahMiskin', 'jumlahTidakMiskin'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provinsi' => 'required|string|max:100',
            'kab_kota' => 'required|string|max:100',
            'presentase_pm' => 'required|numeric',
            'pengeluaran_perkapita' => 'required|numeric',
            'tingkat_pengangguran' => 'required|numeric',
        ]);

        $lastData = Data::latest('id_data')->first();
        $nextId = $lastData ? intval(substr($lastData->id_data, 2)) + 1 : 1;
        $newId = 'DT' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $response = Http::post('http://127.0.0.1:5000/predict', [
            'presentase_pm' => $validated['presentase_pm'],
            'pengeluaran_perkapita' => $validated['pengeluaran_perkapita'],
            'tingkat_pengangguran' => $validated['tingkat_pengangguran'],
        ]);

        $predictedClass = $response->json()['klasifikasi_kemiskinan'];

        Data::create([
            'id_data' => $newId,
            'provinsi' => $validated['provinsi'],
            'kab_kota' => $validated['kab_kota'],
            'presentase_pm' => $validated['presentase_pm'],
            'pengeluaran_perkapita' => $validated['pengeluaran_perkapita'],
            'tingkat_pengangguran' => $validated['tingkat_pengangguran'],
            'klasifikasi_kemiskinan' => $predictedClass,
        ]);

        return redirect()->route('data.index')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id_data)
    {
        $data = Data::findOrFail($id_data);
        return view('data.edit', compact('data'));
    }
    public function update(Request $request, $id_data)
    {
        $request->validate([
            'provinsi' => 'required|string|max:100',
            'kab_kota' => 'required|string|max:100',
            'presentase_pm' => 'required|numeric',
            'pengeluaran_perkapita' => 'required|numeric',
            'tingkat_pengangguran' => 'required|numeric',
        ]);

        $data = Data::findOrFail($id_data);

        // Update data yang ada
        $data->update([
            'provinsi' => $request->input('provinsi'),
            'kab_kota' => $request->input('kab_kota'),
            'presentase_pm' => $request->input('presentase_pm'),
            'pengeluaran_perkapita' => $request->input('pengeluaran_perkapita'),
            'tingkat_pengangguran' => $request->input('tingkat_pengangguran'),
        ]);

        return redirect()->route('data.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function create()
    {
        $lastData = Data::latest('id_data')->first();
        $nextId = $lastData ? intval(substr($lastData->id_data, 3)) + 1 : 1;
        $newId = 'DT' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        return view('data.create', compact('newId'));
    }

    public function destroy($id_data)
    {
        $data = Data::findOrFail($id_data);
        $data->delete();

        return redirect()->route('data.index')->with('success', 'Data berhasil dihapus.');
    }
}