<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilTes extends Model
{
    protected $table = 'hasil_tes';

    protected $fillable = [
        'user_id', 'tipe', 'usia', 'status_penggunaan_id',
        'jumlah_benar', 'total_soal', 'skor',
    ];

    // HasilTes.php
    public function jawabanRinci()
    {
        return $this->hasMany(HasilTesJawaban::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
