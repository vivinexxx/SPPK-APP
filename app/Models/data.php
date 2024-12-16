<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data extends Model
{
    use HasFactory;
    protected $table = 'data';
    protected $primaryKey = 'id_data';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($data) {
            // Cari data terakhir berdasarkan id_data
            $latestData = static::latest('id_data')->first();
    
            // Tentukan ID berikutnya
            if (!$latestData) {
                $nextIdNumber = 515; // ID awal jika tabel kosong
            } else {
                // Ambil angka setelah "DT" dan tambahkan 1
                $lastId = (int) str_replace('DT', '', $latestData->id_data);
                $nextIdNumber = $lastId + 1;
            }
    
            // Pastikan ID baru unik
            do {
                $newId = 'DT' . $nextIdNumber;
                $exists = static::where('id_data', $newId)->exists(); // Cek apakah ID sudah ada
                if ($exists) {
                    $nextIdNumber++; // Tambah angka jika duplikat
                }
            } while ($exists);
    
            $data->id_data = $newId; // Set ID unik
        });
    }

    protected $fillable = [
        'id_data',
        'provinsi',
        'kab_kota',
        'presentase_pm',
        'pengeluaran_perkapita',
        'tingkat_pengangguran',
        'klasifikasi_kemiskinan',
    ];
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->string('id_data')->primary();
            $table->string('provinsi');
            $table->string('kab_kota');
            $table->decimal('persentase_pm', 5, 2);
            $table->decimal('pengeluaran_perkapita', 16, 2);
            $table->decimal('tingkat_pengangguran', 5, 2);
            $table->string('klasifikasi_kemiskinan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('data');
    }
    public function analisis()
    {
        return $this->hasMany(Analisis::class, 'id_data', 'id_data');
    }


}