<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'keluhan',
        'kategori',
        'apoteker_id',
        'dokter_id',
        'nomor_antrian',
        'tgl_berobat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function apoteker()
    {
        return $this->belongsToMany(Apoteker::class);
    }
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
    public function medicalRecord()
    {
        return $this->hasMany(MedicalRecord::class, 'pasien_id');
    }
    public function obat()
    {
        return $this->hasMany(Obat::class, 'pasien_id');
    }
    public function appointment()
    {
        return $this->hasMany(Appointment::class, 'pasien_id');
    }    
}
