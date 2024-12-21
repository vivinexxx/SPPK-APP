<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DataController;

class SearchController extends Controller
{
    public function index()
    {
        return view('search');
    }

    public function searchResult(Request $request)
    {
        // Tangkap parameter region
        $region = $request->input('region');

        // Cek apakah parameter ada
        if ($region) {
            // Mock data berdasarkan region
            $data = [
                'region' => $region,
                'provinsi' => 'Jawa Barat',
                'kota' => 'Bandung',
                'status' => 'Miskin',
                'keputusan' => 'Dana difokuskan bansos',
                'historis' => [
                    [
                        'tahun' => 2024,
                        'provinsi' => 'Jawa Barat',
                        'kota' => 'Bandung',
                        'penduduk_miskin' => '11,3%',
                        'pengeluaran' => 8546,
                        'pengangguran' => '11,65%',
                        'status' => 'Miskin',
                        'keputusan' => 'Dana difokuskan Bansos',
                    ],
                    [
                        'tahun' => 2023,
                        'provinsi' => 'Jawa Barat',
                        'kota' => 'Bandung',
                        'penduduk_miskin' => '12,3%',
                        'pengeluaran' => 8540,
                        'pengangguran' => '11,67%',
                        'status' => 'Miskin',
                        'keputusan' => 'Dana difokuskan Bansos',
                    ],
                ],
            ];

            return view('keputusan', compact('data'));
        }

        // Jika region kosong, redirect kembali ke halaman search
        return redirect()->route('search.index')->with('error', 'Silakan pilih wilayah terlebih dahulu.');
    }

    // public function getKotaProvinsi() {
    //     $regions = Data::select('provinsi', 'kab_kota')->distinct()->get();
    //     return view('search', compact('regions'));
    // }
    public function chart()
    {
        $data = Data::table('data') // Replace with your table name
            ->select('tahun', 'kab_kota', 'presentase_pm', 'pengeluaran_perkapita', 'tingkat_pengangguran')
            ->get();

        // Pass data to the view
        return view('keputusan', compact('data'));
    }
}