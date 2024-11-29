<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class analisis extends Model
{
    use HasFactory;
    protected $table = 'nalisis';
    protected $primaryKey = 'id_analisis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_analisis',
        'id_data',
        'tanggal_analisis',
        'hasil',
    ];

    public function data()
    {
        return $this->belongsTo(Data::class, 'id_data', 'id_data');
    }
}
