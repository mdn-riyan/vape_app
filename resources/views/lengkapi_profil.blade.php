@extends('master')
@section('content')
<form action="{{ route('simpan_profil') }}" method="post" enctype="multipart/form-data" class="mt-4">
    @csrf

    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif

    <div class="form-group">
        <label class="form-control-label">Nama Lengkap</label>
        <input class="form-control" type="text" value="{{ auth()->user()->name }}" readonly>
    </div>

    <div class="form-group">
        <label class="form-control-label">Email</label>
        <input class="form-control" type="email" value="{{ auth()->user()->email }}" readonly>
    </div>

    <div class="form-group">
        <label for="jenis_kelamin">Jenis Kelamin</label>
        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
          <option value="">Pilih salah satu...</option>
          @foreach (['Laki-Laki', 'Perempuan'] as $jk)
            <option value="{{ $jk }}" @selected(old('jenis_kelamin', $siswa->jenis_kelamin ?? '') === $jk)>{{ $jk }}</option>
          @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="tanggal_lahir" class="form-control-label">Tanggal Lahir</label>
        <input class="form-control" type="date" id="tanggal_lahir" name="tanggal_lahir"
               value="{{ old('tanggal_lahir', optional($siswa?->tanggal_lahir)->format('Y-m-d')) }}" required>
    </div>

    <div class="form-group">
        <label for="tingkat_pendidikan">Jenjang Pendidikan</label>
        <select class="form-control" id="tingkat_pendidikan" name="tingkat_pendidikan" required>
          <option value="">Pilih salah satu...</option>
          @foreach (['SD/SMP', 'SMA/SMK'] as $tp)
            <option value="{{ $tp }}" @selected(old('tingkat_pendidikan', $siswa->tingkat_pendidikan ?? '') === $tp)>{{ $tp }}</option>
          @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="kelas" class="form-control-label">Kelas</label>
        <input class="form-control" type="text" id="kelas" name="kelas" placeholder="Misal 12 IPA 1"
               value="{{ old('kelas', $siswa->kelas ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="whatsapp" class="form-control-label">Nomor WhatsApp</label>
        <input class="form-control" type="tel" id="whatsapp" name="whatsapp" placeholder="Masukkan nomor WhatsApp aktif"
               value="{{ old('whatsapp', $siswa->whatsapp ?? '') }}" required>
    </div>

    <div class="form-group">
        <label for="foto_profil" class="form-control-label">Pilih foto profil</label>
        <input type="file" class="form-control" id="foto_profil" name="foto_profil" accept="image/*">
        @if (!empty($siswa?->foto_profil))
          <img src="{{ asset('storage/' . $siswa->foto_profil) }}" class="avatar avatar-xl mt-2" alt="Foto profil">
        @endif
    </div>

    <button type="submit" class="btn btn-dark">
      Simpan <i class="fa-solid fa-check"></i>
    </button>
</form>
@endsection
