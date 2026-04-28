<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    public $timestamps = true;

    protected $fillable = [
        'id_user',
        'tanggal',
        'kuota',
        'status',
    ];

    public function getRouteKeyName()
    {
        return 'id_jadwal';
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function reservasi()
    {
        return $this->hasMany(Reservasi::class, 'id_jadwal');
    }

    /**
     * Check if this slot is booked (has active reservasi).
     */
    public function isBooked(): bool
    {
        return $this->reservasi()
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
    }

    /**
     * Get the effective status considering reservations.
     */
    public function getEffectiveStatusAttribute(): string
    {
        if ($this->isBooked()) {
            return 'booked';
        }
        return $this->status ?? 'aktif';
    }
}
