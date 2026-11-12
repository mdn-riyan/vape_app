<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable= ['user_id', 'jenis_kelamin', 'tanggal_lahir', 'tingkat_pendidikan', 'kelas', 'whatsapp','foto_profil'];
    protected $casts = [
    'tanggal_lahir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
