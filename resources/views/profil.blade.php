@extends('master')
@section('content')

<div class="pt-7 pb-6 bg-cover" style="background-image: url('{{ asset('assets/img/header-orange-purple.jpg') }}'); background-position: bottom;"></div>

<div class="container">
  <div class="card card-body py-2 bg-transparent shadow-none">
    <div class="row">
      <div class="col-auto">
        <div class="avatar avatar-2xl rounded-circle position-relative mt-n7 border border-gray-100 border-4">
          <img src="{{ $siswa?->foto_profil ? asset('storage/' . $siswa->foto_profil) : asset('assets/img/theme/tim.png') }}"
             alt="Foto profil"
             style="width:100%; height:100%; object-fit:cover; object-position:center top;">
        </div>
      </div>
      <div class="col-auto my-auto">
        <h3 class="mb-0 font-weight-bold">{{ $profil->name }}</h3>
        <p class="mb-0">{{ $profil->email }}</p>
      </div>
    </div>
  </div>
</div>

@if ($isGuest)
  <div class="alert bg-gradient-danger text-white" role="alert">
    <strong>Perhatian!</strong> Anda saat ini terdaftar sebagai Tamu. Lengkapi profil untuk mengakses materi dan tes.
  </div>
@endif

<div class="text-end my-3">
  <a href="{{ route('lengkapi_profil') }}" class="btn btn-sm btn-white">
    {{ $siswa ? 'Ubah Profil' : 'Lengkapi Profil' }}
  </a>
</div>

<div class="card border shadow-xs">
  <div class="card-header pb-0 p-3">
    <h6 class="mb-0 font-weight-semibold text-lg">Informasi Data Diri</h6>
  </div>
  <div class="card-body p-3">
    <ul class="list-group">
      @php
        $baris = [
          'Nama Lengkap'       => $profil->name,
          'Email'              => $profil->email,
          'Jenis Kelamin'      => $siswa?->jenis_kelamin,
          'Tanggal Lahir'      => $siswa?->tanggal_lahir?->format('d-m-Y'),
          'Tingkat Pendidikan' => $siswa?->tingkat_pendidikan,
          'Kelas'              => $siswa?->kelas,
          'Nomor WhatsApp'     => $siswa?->whatsapp,
        ];
      @endphp

      @foreach ($baris as $label => $nilai)
        <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
          <span class="text-secondary">{{ $label }}:</span>
          @if ($nilai)
            {{ $nilai }}
          @else
            <span class="badge badge-sm bg-danger">Belum diisi</span>
          @endif
        </li>
      @endforeach

      <li class="list-group-item border-0 ps-0 text-dark font-weight-semibold pb-1 text-sm">
        <span class="text-secondary">Jenis Akses:</span>
        <span class="badge badge-sm border border-success text-success bg-success">{{ $namaRole }}</span>
      </li>
    </ul>
  </div>
</div>

@endsection
