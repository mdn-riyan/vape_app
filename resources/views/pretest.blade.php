@extends('master')
@section('content')

<form action="{{ route($tipe . '.simpan') }}" method="post" class="mt-4">
  @csrf

  <h5 class="mb-3">{{ $tipe === 'pretest' ? 'PreTest' : 'PostTest' }}: Pengetahuan Bahaya Vape</h5>

  @if (session('error'))
    <div class="alert alert-warning">{{ session('error') }}</div>
  @endif

  @if ($errors->any())
    <div class="alert alert-danger">
      @foreach (collect($errors->all())->unique() as $e)
        <div>{{ $e }}</div>
      @endforeach
    </div>
  @endif

  {{-- A. Identitas (diambil otomatis) --}}
  <div class="card border shadow-xs mb-4">
    <div class="card-header pb-0"><h6 class="mb-0">A. Data Responden</h6></div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 form-group">
          <label class="form-control-label">Nama</label>
          <input class="form-control" value="{{ auth()->user()->name }}" readonly>
        </div>
        <div class="col-md-6 form-group">
          <label class="form-control-label">Jenis Kelamin</label>
          <input class="form-control" value="{{ $siswa->jenis_kelamin }}" readonly>
        </div>
        <div class="col-md-6 form-group">
          <label class="form-control-label">Usia</label>
          <input class="form-control" value="{{ $usia }} tahun" readonly>
        </div>
        <div class="col-md-6 form-group">
          <label class="form-control-label">Tingkat Pendidikan</label>
          <input class="form-control" value="{{ $siswa->tingkat_pendidikan }}" readonly>
        </div>
      </div>

      <label class="form-control-label mt-2">{{ rtrim($status->pertanyaan, ':') }}</label>
      @foreach ($status->jawaban as $j)
        <div class="form-check">
          <input class="form-check-input" type="radio" name="status_penggunaan"
                 id="status{{ $j->id }}" value="{{ $j->id }}"
                 @checked(old('status_penggunaan') == $j->id)>
          <label class="form-check-label" for="status{{ $j->id }}">{{ $j->jawaban }}</label>
        </div>
      @endforeach
    </div>
  </div>

  {{-- B. Pengetahuan --}}
  <div class="card border shadow-xs mb-4">
    <div class="card-header pb-0">
      <h6 class="mb-0">B. Kuesioner Pengetahuan</h6>
      <p class="text-sm mb-0">Pilih satu jawaban untuk setiap pernyataan.</p>
    </div>
    <div class="card-body">
      @foreach ($soal as $i => $s)
        <div class="mb-4">
          <p class="mb-2 text-dark">{{ $i + 1 }}. {{ $s->pertanyaan }}</p>
          @foreach ($s->jawaban as $j)
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="jawaban[{{ $s->id }}]"
                     id="j{{ $j->id }}" value="{{ $j->id }}"
                     @checked(old("jawaban.{$s->id}") == $j->id)>
              <label class="form-check-label" for="j{{ $j->id }}">{{ $j->jawaban }}</label>
            </div>
          @endforeach
        </div>
      @endforeach
    </div>
  </div>

  <button type="submit" class="btn btn-dark"
          onclick="return confirm('Jawaban tidak dapat diubah setelah dikirim. Kirim sekarang?')">
    Kirim Jawaban
  </button>
</form>

@endsection
