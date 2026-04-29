<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    protected $primaryKey = 'id_rekam_medis';

    protected $fillable = [
        'id_pasien',
        'id_user',
        'id_reservasi',
        'tanggal',
        'keluhan',
        'subjective',
        'objective',
        'assessment',
        'plan',
        'terapi',
        'tarif',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'id_reservasi');
    }
}
