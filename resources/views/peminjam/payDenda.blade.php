@extends('layouts.app')

@section('content')
    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-xl font-bold mb-4">Bayar Denda</h1>
        <p>Denda: Rp {{ number_format($loan->denda) }}</p>
        <button id="pay-button" class="bg-blue-500 text-white px-4 py-2 rounded">Bayar Sekarang</button>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    fetch('/midtrans/client-notify', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(result)
                    }).finally(function() {
                        window.location.href = '/peminjam/riwayat';
                    });
                },
                onPending: function(result) {
                    fetch('/midtrans/client-notify', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(result)
                    }).then(function() {
                        alert('Pembayaran sedang diproses. Silakan tunggu beberapa saat, lalu cek riwayat kembali.');
                    }).catch(function() {
                        alert('Pembayaran pending, namun update status gagal.');
                    });
                },
                onError: function(result) {
                    alert('Error saat pembayaran. Silakan ulangi.');
                }
            });
        };
    </script>
@endsection