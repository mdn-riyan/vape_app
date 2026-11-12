<div class="table-responsive">
  <table class="table align-items-center">
    <thead>
      <tr>
        <th>#</th><th>Nama</th><th>Kelas</th>
        <th class="text-center">Skor</th><th class="text-center">Dikerjakan</th><th></th>
      </tr>
    </thead>
    <tbody>
      @forelse ($data as $i => $h)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $h->user->name }}</td>
          <td>{{ $h->user->siswa?->kelas ?? '-' }}</td>
          <td class="text-center">{{ $h->skor }} ({{ $h->jumlah_benar }}/{{ $h->total_soal }})</td>
          <td class="text-center">{{ $h->created_at->format('d-m-Y H:i') }}</td>
          <td class="text-end">
            <a href="{{ route('lihat_hasil.detail', $h) }}" class="btn btn-sm btn-white mb-0">Lihat jawaban</a>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-secondary py-4">Belum ada data.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
