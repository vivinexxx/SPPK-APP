<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Data;
use App\Models\Analisis;

class SearchController extends Controller
{
    public function index()
    {
        // Ambil daftar wilayah unik dari database
        $regions = Data::select('provinsi', 'kab_kota')
            ->distinct()
            ->orderBy('provinsi')
            ->get();

        return view('search', compact('regions'));
    }

    public function searchResult(Request $request)
    {
        // Validasi input
        $request->validate([
            'region' => 'required',
        ]);
    
        // Memisahkan provinsi dan kabupaten/kota
        [$provinsi, $kab_kota] = explode('_', $request->input('region'));
    
        // Ambil data terbaru berdasarkan wilayah
        $data = Data::where('provinsi', str_replace('_', ' ', $provinsi))
            ->where('kab_kota', str_replace('_', ' ', $kab_kota))
            ->orderBy('tahun', 'desc')
            ->first();
    
        if (!$data) {
            // Jika data tidak ditemukan, kembalikan dengan pesan error
            return redirect()->route('search.index')->with('error', 'Data wilayah tidak ditemukan.');
        }
    
        // Tentukan hasil keputusan
        $keputusan = ($data->klasifikasi_kemiskinan == 'Miskin')
            ? 'Dana difokuskan Bansos'
            : 'Dana difokuskan untuk kepentingan infrastruktur';
    
        // Ambil data historis berdasarkan wilayah
        $historis = Data::where('provinsi', $data->provinsi)
            ->where('kab_kota', $data->kab_kota)
            ->orderBy('tahun', 'desc')
            ->get();
    
        // Simpan hasil analisis ke dalam database
        try {
            $analisis = new Analisis();
            $analisis->id_analisis = uniqid('A-'); // Generate ID analisis unik
            $analisis->id_data = $data->id_data; // ID data terkait
            $analisis->hasil = $keputusan; // Keputusan analisis
            $analisis->save(); // Simpan ke database
    
            // Redirect dengan pesan sukses
            return redirect()->route('search.index')->with('success', 'Keputusan berhasil disimpan ke database.');
        } catch (\Exception $e) {
            // Tangani error dan kembalikan pesan error
            return redirect()->route('search.index')->with('error', 'Terjadi kesalahan saat menyimpan keputusan.');
        }
    }
    

  
    public function chart()
    {
        $data = Data::table('data') // Replace with your table name
            ->select('tahun', 'kab_kota', 'presentase_pm', 'pengeluaran_perkapita', 'tingkat_pengangguran')
            ->get();

        // Pass data to the view
        return view('keputusan', compact('data'));
    }
}

