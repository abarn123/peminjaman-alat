@extends('layouts.app')

@section('content')
    <div class="mb-4">
        <h3>Input Denda untuk Pengembalian Terlambat</h3>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Peminjam:</strong> {{ $loan->user->name }}</p>
            <p><strong>Alat:</strong> {{ $loan->tool->nama_alat }}</p>
            <p><strong>Tanggal Kembali Rencana:</strong> {{ $loan->tanggal_kembali_rencana }}</p>
            <p><strong>Tanggal Kembali Aktual:</strong> {{ $loan->tanggal_kembali_aktual }}</p>
            <p><strong>Status:</strong> {{ $loan->status }}</p>
            <p><strong>Denda Terhitung:</strong> Rp {{ number_format($calculatedFine) }}</p>
        </div>
    </div>

    <form action="{{ route('admin.returns.fine', $loan->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Denda (Rp)</label>
            <input type="number" name="denda" class="form-control" value="{{ old('denda', $loan->denda ?: $calculatedFine) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Denda</button>
        <a href="{{ route('admin.returns.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
