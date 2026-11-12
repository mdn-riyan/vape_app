<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilTesJawaban extends Model
{
    protected $table = 'hasil_tes_jawaban';
    public $timestamps = false;
    protected $fillable = ['hasil_tes_id', 'pertanyaan_id', 'jawaban_id', 'benar'];

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }

    public function pilihan()
    {
        return $this->belongsTo(Jawaban::class, 'jawaban_id');
    }
}
