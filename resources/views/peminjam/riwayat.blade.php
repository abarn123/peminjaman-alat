@extends('layouts.app')

@section('content')
    <h3>Riwayat Peminjaman Saya</h3>

    <div class="card mt-3">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Alat</th>
                        <th>Tgl Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th>Status</th>
                        <th>Dikembalikan</th>
                        <th>Catatan</th>
                        <th>Bayar Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td>{{ $loan->tool->nama_alat }}</td>
                            <td>{{ $loan->tanggal_pinjam }}</td>
                            <td>{{ $loan->tanggal_kembali_rencana }}</td>
                            <td>
                                @if($loan->status == 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                                @elseif($loan->status == 'disetujui')
                                    <span class="badge bg-primary">Sedang Dipinjam</span>
                                @elseif($loan->status == 'kembali')
                                    <span class="badge bg-success">Sudah Dikembalikan</span>
                                @elseif($loan->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                              </td>
                              <td>
                                @if($loan->status == 'kembali' && $loan->tanggal_kembali_aktual)
                                    @php
                                        $rencana = strtotime($loan->tanggal_kembali_rencana);
                                        $aktual = strtotime($loan->tanggal_kembali_aktual);
                                        $isLate = $aktual > $rencana;
                                    @endphp
                                    @if($isLate)
                                        <span class="badge bg-danger">Telat</span>
                                    @else
                                        <span class="badge bg-success">Tepat Waktu</span>
                                    @endif
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                              </td>
                              <td>
                                @if($loan->status == 'disetujui')
                                    <small class="text-muted">Harap kembalikan ke petugas sebelum tanggal rencana.</small>
                                @elseif($loan->status == 'kembali')
                                    <small class="text-success">Diterima tanggal {{ $loan->tanggal_kembali_aktual }}</small>
                                @endif
                              </td>
                              <td>
                                @if($isLate)
                                    <button type="button"
                                        class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#qrisModal"
                                        data-amount="{{ number_format($loan->denda, 0, ',', '.') }}">
                                        Bayar Denda
                                    </button>
                                @else
                                    -
                                @endif
                              </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Belum ada riwayat peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="qrisModal" tabindex="-1" aria-labelledby="qrisModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bayar Denda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p>Jumlah denda: <strong>Rp <span id="qrisAmount"></span></strong></p>
                <p>Scan QRIS di bawah untuk melakukan pembayaran:</p>
                <img src="{{ asset('images/qris.png') }}" class="img-fluid" alt="QRIS Pembayaran">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var qrisModal = document.getElementById('qrisModal');
    qrisModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var amount = button.getAttribute('data-amount');
        qrisModal.querySelector('#qrisAmount').textContent = amount;
    });
});
</script>
@endsection