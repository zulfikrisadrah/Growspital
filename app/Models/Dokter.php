<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'spesialis',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pasien()
    {
        return $this->hasMany(Pasien::class, 'dokter_id');
    }
    public function medicalRecord()
    {
        return $this->hasMany(MedicalRecord::class, 'dokter_id');
    }
    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'dokter_id');
    }
}
