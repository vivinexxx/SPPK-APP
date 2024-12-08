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
            $latestData = static::latest('id_data')->first();

            if (!$latestData) {
                $nextIdNumber = 1;
            } else {
                $lastId = (int) str_replace('DT', '', $latestData->id_data);
                $nextIdNumber = $lastId + 1;
            }

            $data->id_data = 'ADM' . $nextIdNumber;
        });
    }

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
    public function up()
    {
        Schema::create('data', function (Blueprint $table) {
            $table->id('id_data');
            $table->string('provinsi');
            $table->string('kab_kota');
            $table->decimal('persentase_pm', 5, 2);
            $table->decimal('pengeluaran_perkapita', 16, 2);
            $table->decimal('tingkat_pengangguran', 5, 2);
            $table->string('klasifikasi_kemiskinan');
            $table->timestamps();
        });
    }


    public function analisis()
    {
        return $this->hasMany(Analisis::class, 'id_data', 'id_data');
    }


}
