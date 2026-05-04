<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoRekamMedis extends Model
{
    protected $table = 'foto_rekam_medis';
    protected $primaryKey = 'id_foto';

    protected $fillable = [
        'id_rekam_medis',
        'foto_path',
        'keterangan',
    ];

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class, 'id_rekam_medis');
    }
}
