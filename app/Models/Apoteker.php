<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apoteker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pasien()
    {
        return $this->hasMany(Pasien::class, 'apoteker_id');
    }
    public function obat()
    {
        return $this->hasMany(Obat::class, 'apoteker_id');
    }
}
