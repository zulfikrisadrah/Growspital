<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'obat_id',
        'name',
        'deskripsi',
        'apoteker_id',
        'pasien_id',
        'tipe',
        'stok',
    ];

    public function apoteker()
    {
        return $this->belongsToMany(Apoteker::class);
    }
    public function pasien()
    {
        return $this->belongsToMany(Pasien::class);
    }
    public function medicalRecord()
    {
        return $this->hasMany(MedicalRecord::class);
    }
}
