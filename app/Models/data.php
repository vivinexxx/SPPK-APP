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

    protected $fillable = [
        'id_data',
        'id_admin',
        'provinsi',
        'kab_kota',
        'presentase_pm',
        'pengeluaran_perkapita',
        'tingkat_pengangguran',
        'klasifikasi_kemiskinan',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function analisis()
    {
        return $this->hasMany(Analisis::class, 'id_data', 'id_data');
    }
}
