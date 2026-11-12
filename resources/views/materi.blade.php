@extends('master')
@section('content')

<div class="card mt-4">
  <div class="card-body">
    <h5 class="mb-1">Materi: Mengenal Rokok Elektrik</h5>
    <p class="text-sm text-secondary">Tonton video berikut sampai selesai sebelum mengerjakan PostTest.</p>

    <div class="ratio ratio-16x9 bg-dark rounded">
      <video controls preload="metadata" controlsList="nodownload">
        <source src="{{ asset('assets/video/materi.mp4') }}" type="video/mp4">
        Browser Anda tidak mendukung pemutaran video.
      </video>
    </div>
  </div>
</div>

@endsection
