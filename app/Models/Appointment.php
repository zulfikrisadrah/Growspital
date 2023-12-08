<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokter_id',
        'pasien_id',
        'status',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
    public function medicalRecord()
{
    return $this->hasOne(MedicalRecord::class);
}
}
