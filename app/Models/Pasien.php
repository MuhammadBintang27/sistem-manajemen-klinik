<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'id_pasien';

    protected $fillable = [
        'nik',
        'nama',
        'alamat',
        'jenis_kelamin',
        'no_hp',
    ];

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_pasien');
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'id_pasien');
    }
}
