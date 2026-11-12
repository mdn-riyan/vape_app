@extends('master')
@section('content')

<ul class="nav nav-tabs mt-4" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pre-pane" type="button" role="tab">
      PreTest <span class="badge bg-success">{{ $pretest->count() }}</span>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#post-pane" type="button" role="tab">
      PostTest <span class="badge bg-info">{{ $posttest->count() }}</span>
    </button>
  </li>
</ul>

<div class="tab-content">
  <div class="tab-pane show active" id="pre-pane" role="tabpanel">
    @include('tes._tabel', ['data' => $pretest])
  </div>
  <div class="tab-pane" id="post-pane" role="tabpanel">
    @include('tes._tabel', ['data' => $posttest])
  </div>
</div>

@endsection
