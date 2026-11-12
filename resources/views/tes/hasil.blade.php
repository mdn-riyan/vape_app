@extends('master')
@section('content')

<div class="card border shadow-xs mt-4">
  <div class="card-body text-center py-5">
    <h6 class="text-secondary">Hasil {{ $tipe === 'pretest' ? 'PreTest' : 'PostTest' }}</h6>
    <h1 class="display-3 font-weight-bold mb-1">{{ $hasil->skor }}</h1>
    <p class="text-sm mb-0">{{ $hasil->jumlah_benar }} benar dari {{ $hasil->total_soal }} pernyataan</p>

    @if ($pretest)
      @php $selisih = $hasil->skor - $pretest->skor; @endphp
      <hr>
      <p class="mb-0">
        Skor PreTest: <strong>{{ $pretest->skor }}</strong> &rarr;
        PostTest: <strong>{{ $hasil->skor }}</strong>
        <span class="badge {{ $selisih >= 0 ? 'bg-success' : 'bg-danger' }}">
          {{ $selisih >= 0 ? '+' : '' }}{{ $selisih }}
        </span>
      </p>
    @elseif ($tipe === 'pretest')
      <a href="{{ url('/materi') }}" class="btn btn-dark mt-4">Lanjut ke Materi</a>
    @endif
  </div>
</div>

@endsection
