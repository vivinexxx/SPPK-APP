<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;
use App\Models\Analisis;

use Illuminate\Support\Facades\DB;
class DataController extends Controller
{
    public function index()
    {
        $lastData = Data::latest('id_data')->first();
        $nextId = $lastData ? intval(substr($lastData->id_data, 3)) + 1 : 1;
        $newId = 'DT' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $data = Data::with(['analisis'])->get();
        $analisis = Analisis::all();

        // Hitung jumlah miskin dan kaya
        $jumlahMiskin = $data->where('klasifikasi', 'Miskin')->count();
        $jumlahTidakMiskin = $data->where('klasifikasi', 'Tidak Miskin')->count();

        return view('data.index', compact('newId', 'data', 'analisis', 'jumlahMiskin', 'jumlahTidakMiskin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'provinsi' => 'required|string|max:255',
            'kab_kota' => 'required|string|max:255',
            'persentase_miskin' => 'required|numeric',
            'pengeluaran' => 'required|numeric',
            'tingkat_pengangguran' => 'required|numeric',
            'klasifikasi' => 'required|string',
        ]);

        Data::create($request->all());

        return redirect()->route('data.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $Data = Data::findOrFail($id);

        return view('data.edit', compact('Data'));
    }

    public function destroy($id)
    {
        $Data = Data::findOrFail($id);
        $Data->delete();

        return redirect()->route('data.index')->with('success', 'Data berhasil dihapus.');
    }
}

