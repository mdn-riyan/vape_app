@extends('master')

@section('content')

@if (is_null($daftar))
  <div class="card border shadow-xs mt-4">
    <div class="card-body">
      <h5 class="mb-1">Selamat datang, {{ auth()->user()->name }}</h5>
      <p class="text-sm mb-0">Mulai dari PreTest, lanjutkan dengan Materi, lalu kerjakan PostTest.</p>
    </div>
  </div>
@else
<div class="card border shadow-xs mb-4 mt-4">
  <div class="card-header border-bottom pb-0">
    <h6 class="font-weight-semibold text-lg mb-0">Daftar Siswa</h6>
    <p class="text-sm">Status online berarti aktif dalam 5 menit terakhir.</p>
  </div>

  <div class="card-body px-0 py-0">
    <form method="get" class="border-bottom py-3 px-3">
      <div class="input-group w-sm-25 ms-auto">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama siswa">
        <button class="btn btn-dark mb-0" type="submit">Cari</button>
      </div>
    </form>

    <div class="table-responsive p-0">
      <table class="table align-items-center mb-0">
        <thead class="bg-gray-100">
          <tr>
            <th class="text-secondary text-xs font-weight-semibold opacity-7">Siswa</th>
            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Kelas</th>
            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Status</th>
            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Terakhir aktif</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($daftar as $s)
            @php
              $terakhir = $s->user->last_seen_at;
              $online   = $terakhir && $terakhir->gte(now()->subMinutes(5));
              $foto     = $s->foto_profil ? asset('storage/' . $s->foto_profil) : asset('assets/img/team-2.jpg');
            @endphp
            <tr>
              <td>
                <div class="d-flex px-2 py-1">
                  <div class="avatar avatar-sm rounded-circle me-2" style="width:36px;height:36px;overflow:hidden;">
                    <img src="{{ $foto }}" alt="{{ $s->user->name }}"
                         style="width:100%;height:100%;object-fit:cover;object-position:center top;">
                  </div>
                  <div class="d-flex flex-column justify-content-center ms-1">
                    <h6 class="mb-0 text-sm font-weight-semibold">{{ $s->user->name }}</h6>
                    <p class="text-sm text-secondary mb-0">{{ $s->user->email }}</p>
                  </div>
                </div>
              </td>
              <td>
                <p class="text-sm text-dark font-weight-semibold mb-0">{{ $s->kelas }}</p>
                <p class="text-sm text-secondary mb-0">{{ $s->tingkat_pendidikan }}</p>
              </td>
              <td class="align-middle text-center text-sm">
                @if ($online)
                  <span class="badge badge-sm border border-success text-success bg-success">Online</span>
                @else
                  <span class="badge badge-sm border border-secondary text-secondary bg-secondary">Offline</span>
                @endif
              </td>
              <td class="align-middle text-center">
                <span class="text-secondary text-sm font-weight-normal">
                  {{ $online ? 'Sekarang' : ($terakhir?->diffForHumans() ?? '-') }}
                </span>
              </td>
            </tr>
          @empty
            <tr><td colspan="4" class="text-center text-secondary py-4">Belum ada siswa.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="border-top py-3 px-3 d-flex align-items-center">
      <p class="font-weight-semibold mb-0 text-dark text-sm">
        Menampilkan {{ $daftar->firstItem() ?? 0 }}-{{ $daftar->lastItem() ?? 0 }} dari {{ $daftar->total() }}
      </p>
      <div class="ms-auto">{{ $daftar->links() }}</div>
    </div>
  </div>
</div>
@endif

@endsection
