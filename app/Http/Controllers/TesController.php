<?php

namespace App\Http\Controllers;

use App\Models\HasilTes;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TesController extends Controller
{
    private function soal(): array
    {
        return [
            Pertanyaan::with('jawaban')->where('jenis_kuesioner_id', 1)->first(),
            Pertanyaan::with('jawaban')->where('jenis_kuesioner_id', 2)->orderBy('id')->get(),
        ];
    }

    /** Kembalikan redirect bila user belum boleh mengerjakan, atau null bila boleh. */
    private function tolak(string $tipe)
    {
        $user = Auth::user()->load(['roles', 'siswa']);

        abort_unless($user->roles->contains('nama_role', 'Siswa'), 403);

        if (! $user->siswa) {
            return redirect()->route('lengkapi_profil');
        }

        $sudah = HasilTes::where('user_id', $user->id)->pluck('tipe');

        if ($sudah->contains($tipe)) {
            return redirect()->route('hasil_tes', $tipe);
        }

        if ($tipe === 'posttest' && ! $sudah->contains('pretest')) {
            return redirect('/pretest')->with('error', 'Kerjakan PreTest terlebih dahulu.');
        }

        return null;
    }

    public function form(string $tipe)
    {
        if ($r = $this->tolak($tipe)) {
            return $r;
        }

        $siswa = Auth::user()->siswa;
        [$status, $soal] = $this->soal();

        return view('tes.form', [
            'tipe'   => $tipe,
            'siswa'  => $siswa,
            'usia'   => $siswa->tanggal_lahir->age,
            'status' => $status,
            'soal'   => $soal,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $tipe)
    {
        if ($r = $this->tolak($tipe)) {
            return $r;
        }

        [$status, $soal] = $this->soal();

        // Setiap jawaban harus dipilih dan harus milik pertanyaannya
        $rules = ['status_penggunaan' => ['required', Rule::in($status->jawaban->pluck('id')->all())]];
        foreach ($soal as $s) {
            $rules["jawaban.{$s->id}"] = ['required', Rule::in($s->jawaban->pluck('id')->all())];
        }

        $request->validate($rules, [
            'required' => 'Masih ada pertanyaan yang belum dijawab.',
            'in'       => 'Jawaban tidak valid.',
        ]);

        // Skor dihitung di server, bukan dari data yang dikirim browser
        $baris = [];
        $benar = 0;
        foreach ($soal as $s) {
            $pilih = (int) $request->input("jawaban.{$s->id}");
            $ok    = (bool) $s->jawaban->firstWhere('id', $pilih)?->benar;
            $benar += $ok ? 1 : 0;

            $baris[] = ['pertanyaan_id' => $s->id, 'jawaban_id' => $pilih, 'benar' => $ok];
        }

        $user = Auth::user();

        DB::transaction(function () use ($user, $tipe, $request, $soal, $benar, $baris) {
            $hasil = HasilTes::create([
                'user_id'              => $user->id,
                'tipe'                 => $tipe,
                'usia'                 => $user->siswa->tanggal_lahir->age,
                'status_penggunaan_id' => (int) $request->status_penggunaan,
                'jumlah_benar'         => $benar,
                'total_soal'           => $soal->count(),
                'skor'                 => (int) round($benar / $soal->count() * 100),
            ]);

            $hasil->jawabanRinci()->createMany($baris);
        });

        return redirect()->route('hasil_tes', $tipe);
    }

    public function hasil(string $tipe)
    {
        $hasil = HasilTes::where('user_id', Auth::id())->where('tipe', $tipe)->firstOrFail();

        $pretest = $tipe === 'posttest'
            ? HasilTes::where('user_id', Auth::id())->where('tipe', 'pretest')->first()
            : null;

        return view('tes.hasil', compact('hasil', 'tipe', 'pretest'));
    }

    public function read()
    {
        return view('tes.hasil_siswa');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
