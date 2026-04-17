<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Loan extends Model
{
    // Semua field mass assignable kecuali primary key
    protected $guarded = [];

    // Relasi ke user yang meminjam
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke alat yang dipinjam
    public function tool()
    {
        return $this->belongsTo(Tool::class);
    }

    // Relasi ke petugas yang mengolah pinjaman
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // Cek apakah pengembalian terlambat berdasarkan tanggal aktual
    public function isLate()
    {
        return $this->tanggal_kembali_aktual
            && Carbon::parse($this->tanggal_kembali_aktual)->startOfDay()->gt(
                Carbon::parse($this->tanggal_kembali_rencana)->startOfDay()
            );
    }

    // Hitung denda berdasarkan hari keterlambatan
    public function calculateFine($ratePerDay = 5000)
    {
        if (!$this->isLate()) {
            return 0;
        }

        $daysLate = Carbon::parse($this->tanggal_kembali_aktual)
            ->startOfDay()
            ->diffInDays(Carbon::parse($this->tanggal_kembali_rencana)->startOfDay());

        return $daysLate * $ratePerDay;
    }

    public function createMidtransTransaction()
{
    // Hitung denda jika belum ada
    if (!$this->denda) {
        $this->denda = $this->calculateFine();
    }

    // Generate order_id unik
    $orderId = 'LOAN-' . $this->id . '-' . time();

    // Setup Midtrans
    \Midtrans\Config::$serverKey = config('midtrans.server_key');
    \Midtrans\Config::$isProduction = config('midtrans.is_production');
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    $params = [
        'transaction_details' => [
            'order_id' => $orderId,
            'gross_amount' => $this->denda,
        ],
        'customer_details' => [
            'first_name' => $this->user->name,
            'email' => $this->user->email,
        ],
        'item_details' => [
            [
                'id' => 'DENDA-' . $this->id,
                'price' => $this->denda,
                'quantity' => 1,
                'name' => 'Denda Peminjaman Alat',
            ],
        ],
        'callbacks' => [
            'finish' => url('/peminjam/riwayat'),
            'notification' => url('/midtrans/callback'),
        ],
    ];

    $snapToken = \Midtrans\Snap::getSnapToken($params);

    // Simpan ke database
    $this->update([
        'midtrans_order_id' => $orderId,
        'midtrans_status' => 'pending',
    ]);

    return $snapToken;
}    
}

