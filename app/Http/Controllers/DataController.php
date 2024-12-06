<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;
use App\Models\Analisis;

use Illuminate\Support\Facades\DB;
class DataController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');
        $data = Data::query()
            ->when($query, function ($q) use ($query) {
                $q->where('provinsi', 'like', "%{$query}%")
                    ->orWhere('kab_kota', 'like', "%{$query}%");
            })
            ->paginate(10); // Anda bisa menyesuaikan paginasi
        $data = Data::paginate(1); // 10 adalah jumlah item per halaman
        $lastData = Data::latest('id_data')->first();
        $nextId = $lastData ? intval(substr($lastData->id_data, 3)) + 1 : 1;
        $newId = 'DT' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $data = Data::with(['analisis'])->get();
        $analisis = Analisis::all();

        // Hitung jumlah miskin dan kaya
        $jumlahMiskin = $data->where('klasifikasi_kemiskinan', 'Miskin')->count();
        $jumlahTidakMiskin = $data->where('klasifikasi_kemiskinan', 'Tidak Miskin')->count();

        return view('data.index', compact('newId', 'data', 'analisis', 'jumlahMiskin', 'jumlahTidakMiskin'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'provinsi' => 'required|string|max:100',
            'kab_kota' => 'required|string|max:100',
            'persentase_pm' => 'required|numeric|between:0,99.99',
            'pengeluaran_perkapita' => 'required|numeric|digits_between:1,16',
            'tingkat_pengangguran' => 'required|numeric|between:0,99.99',
            'klasifikasi_kemiskinan' => 'required|string|max:255',
        ]);


        Data::create($request->all());

        return redirect()->route('data.index')->with('success', 'Data berhasil ditambahkan.');
    }
    public function create()
    {
        $lastData = Data::latest('id_data')->first();
        $nextId = $lastData ? intval(substr($lastData->id_data, 3)) + 1 : 1;
        $newId = 'DT' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        return view('data.create', compact('newId'));
    }


    public function edit($id_data)
    {
        $Data = Data::findOrFail($id_data);

        return view('data.edit', compact('Data'));
    }

    public function destroy($id_data)
    {
        $Data = Data::findOrFail($id_data);
        $Data->delete();

        return redirect()->route('data.index')->with('success', 'Data berhasil dihapus.');
    }
}

