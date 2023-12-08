<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'medicalRecord_id',
        'appointment_id',
        'tindakan',
        'tgl_berobat',
        'dokter_id',
        'pasien_id',
        'obat_id',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
    public function obat()
    {
        return $this->belongsTo(Obat::class, 'obat_id');
    }
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
