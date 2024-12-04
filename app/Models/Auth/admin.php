<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    use HasFactory;
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    public $incrementing = false;
    protected $keyType = 'string';

      protected static function boot()
    {
        parent::boot();

        static::creating(function ($admin) {
            $latestadmin = static::latest('id_admin')->first();

            if (!$latestadmin) {
                $nextIdNumber = 1;
            } else {
                $lastId = (int) str_replace('ADM', '', $latestadmin->id_admin);
                $nextIdNumber = $lastId + 1;
            }

            $admin->id_admin = 'ADM' . $nextIdNumber;
        });
    }

    protected $fillable = [
        'id_admin',
        'username',
        'password',
    ];

    public function data()
    {
        return $this->hasMany(Data::class, 'id_admin', 'id_admin');
    }
}
