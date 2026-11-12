<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilTes;
use App\Models\Jawaban;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HasilAdminController extends Controller
{
    public function index()
    {
        $hasil = HasilTes::with('user.siswa')->latest()->get()->groupBy('tipe');

        return view('tes.hasil_siswa', [
            'pretest'  => $hasil->get('pretest', collect()),
            'posttest' => $hasil->get('posttest', collect()),
        ]);
    }

    public function detail(HasilTes $hasil)
    {
        return view('tes.detail_siswa', $this->data($hasil));
    }

    public function pdf(HasilTes $hasil)
    {
        $d = $this->data($hasil);

        return Pdf::loadView('tes.pdf', $d)
            ->download("{$hasil->tipe}-{$hasil->user->name}.pdf");
    }

    public function csv(HasilTes $hasil): StreamedResponse
    {
        $d = $this->data($hasil);

        return response()->streamDownload(function () use ($d) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // agar Excel membaca UTF-8
            fputcsv($out, ['No', 'Pernyataan', 'Jawaban Siswa', 'Kunci', 'Hasil']);
            foreach ($d['baris'] as $b) {
                fputcsv($out, [$b['no'], $b['soal'], $b['jawab'], $b['kunci'], $b['benar'] ? 'Benar' : 'Salah']);
            }
            fclose($out);
        }, "{$d['hasil']->tipe}-{$d['hasil']->user->name}.csv", ['Content-Type' => 'text/csv']);
    }

    private function data(HasilTes $hasil): array
    {
        $hasil->load(['user.siswa', 'jawabanRinci.pertanyaan.jawaban', 'jawabanRinci.pilihan']);

        $baris = $hasil->jawabanRinci->sortBy('pertanyaan_id')->values()->map(fn ($r, $i) => [
            'no'    => $i + 1,
            'soal'  => $r->pertanyaan->pertanyaan,
            'jawab' => $r->pilihan->jawaban,
            'kunci' => $r->pertanyaan->jawaban->firstWhere('benar', true)?->jawaban,
            'benar' => (bool) $r->benar,
        ])->all();

        return [
            'hasil'  => $hasil,
            'baris'  => $baris,
            'status' => Jawaban::find($hasil->status_penggunaan_id)?->jawaban,
        ];
    }
}
