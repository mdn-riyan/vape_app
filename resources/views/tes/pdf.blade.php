<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #999; padding: 4px; text-align: left; vertical-align: top; }
    th { background: #eee; }
  </style>
</head>
<body>
  <h3>Hasil {{ strtoupper($hasil->tipe) }}: Pengetahuan Bahaya Vape</h3>
  <p>
    Nama: {{ $hasil->user->name }}<br>
    Jenis kelamin: {{ $hasil->user->siswa?->jenis_kelamin }}<br>
    Usia: {{ $hasil->usia }} tahun<br>
    Pendidikan: {{ $hasil->user->siswa?->tingkat_pendidikan }} · Kelas: {{ $hasil->user->siswa?->kelas }}<br>
    Status penggunaan: {{ $status }}<br>
    Skor: {{ $hasil->skor }} ({{ $hasil->jumlah_benar }} benar dari {{ $hasil->total_soal }})
  </p>
  <table>
    <tr><th>No</th><th>Pernyataan</th><th>Jawaban</th><th>Kunci</th><th>Hasil</th></tr>
    @foreach ($baris as $b)
      <tr>
        <td>{{ $b['no'] }}</td><td>{{ $b['soal'] }}</td>
        <td>{{ $b['jawab'] }}</td><td>{{ $b['kunci'] }}</td>
        <td>{{ $b['benar'] ? 'Benar' : 'Salah' }}</td>
      </tr>
    @endforeach
  </table>
</body>
</html>
