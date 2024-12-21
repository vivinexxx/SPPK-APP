<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analisis;
use App\Models\Data;

class AnalisisController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data provinsi yang dipilih dari request
        $provinsi = $request->input('provinsi', ''); // Default tidak ada filter
    
        // Query untuk mengambil data berdasarkan provinsi yang dipilih
        $data = Data::query()
            ->when($provinsi && $provinsi != 'Semua', function ($query) use ($provinsi) {
                return $query->where('provinsi', $provinsi); // Filter berdasarkan provinsi yang dipilih
            })
            ->get(); // Jika "Semua" dipilih, maka tidak ada filter provinsi
    
        // Hitung jumlah miskin dan tidak miskin dari data yang difilter
      
        $jumlahTidakMiskin = $data->where('klasifikasi_kemiskinan', 'Tidak Miskin')->count();
        $jumlahMiskin = $data->where('klasifikasi_kemiskinan', 'Miskin')->count();
    
        // Jika request adalah AJAX, kirimkan data dalam format JSON
        if ($request->ajax()) {
            return response()->json([
                'jumlahTidakMiskin' => $jumlahTidakMiskin,
                'jumlahMiskin' => $jumlahMiskin,
            ]);
        }

        // Array Provinsi Indonesia
        $provinsiList = [
            'Aceh', 'Bali', 'Banten', 'Bengkulu', 'D I Yogyakarta', 'DKI Jakarta', 'Gorontalo', 'Jambi', 'Jawa Barat',
            'Jawa Tengah', 'Jawa Timur', 'Kalimantan Barat', 'Kalimantan Selatan', 'Kalimantan Tengah', 'Kalimantan Timur',
            'Kalimantan Utara', 'Kepulauan Riau', 'Lampung', 'Maluku', 'Maluku Utara', 'Nusa Tenggara Barat', 'Nusa Tenggara Timur',
            'Papua', 'Papua Barat', 'Riau', 'Sulawesi Barat', 'Sulawesi Selatan', 'Sulawesi Tengah', 'Sulawesi Tenggara', 'Sulawesi Utara',
            'Sumatera Barat', 'Sumatera Selatan', 'Sumatera Utara', 'Bangka Belitung', 'Gorontalo', 'Nusa Tenggara', 'Maluku'
        ];

        // Kirim data ke view
        return view('analisis.index', [
            'data' => $data,
            'jumlahTidakMiskin' => $jumlahTidakMiskin,
            'jumlahMiskin' => $jumlahMiskin,
            'provinsi' => $provinsi, // Mengirimkan data provinsi yang dipilih
            'provinsiList' => $provinsiList, // Mengirimkan list provinsi ke view
        ]);
    }

}