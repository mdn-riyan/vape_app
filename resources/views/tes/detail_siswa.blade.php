@extends('master')
@section('content')

<div class="card border shadow-xs mt-4">
  <div class="card-header d-flex align-items-center">
    <div>
      <h6 class="mb-0">{{ strtoupper($hasil->tipe) }}: {{ $hasil->user->name }}</h6>
      <p class="text-sm mb-0">
        {{ $hasil->user->siswa?->kelas }} · {{ $hasil->usia }} tahun · Status penggunaan: {{ $status }}
        · Skor <strong>{{ $hasil->skor }}</strong> ({{ $hasil->jumlah_benar }}/{{ $hasil->total_soal }})
      </p>
    </div>
    <div class="ms-auto">
      <a href="{{ route('lihat_hasil.pdf', $hasil) }}" class="btn btn-sm btn-dark mb-0">PDF</a>
      <a href="{{ route('lihat_hasil.excel', $hasil) }}" class="btn btn-sm btn-success mb-0">Excel</a>
      <a href="{{ route('lihat_hasil') }}" class="btn btn-sm btn-white mb-0">Kembali</a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table mb-0">
      <thead><tr><th>No</th><th>Pernyataan</th><th>Jawaban</th><th>Kunci</th><th>Hasil</th></tr></thead>
      <tbody>
        @foreach ($baris as $b)
          <tr>
            <td>{{ $b['no'] }}</td>
            <td class="text-wrap">{{ $b['soal'] }}</td>
            <td>{{ $b['jawab'] }}</td>
            <td>{{ $b['kunci'] }}</td>
            <td>
              <span class="badge {{ $b['benar'] ? 'bg-success' : 'bg-danger' }}">
                {{ $b['benar'] ? 'Benar' : 'Salah' }}
              </span>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

@endsection
