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
            && Carbon::parse($this->tanggal_kembali_aktual)->gt(Carbon::parse($this->tanggal_kembali_rencana));
    }

    // Hitung denda berdasarkan hari keterlambatan
    public function calculateFine($ratePerDay = 5000)
    {
        if (!$this->isLate()) {
            return 0;
        }

        $daysLate = Carbon::parse($this->tanggal_kembali_aktual)
            ->diffInDays(Carbon::parse($this->tanggal_kembali_rencana));

        return $daysLate * $ratePerDay;
    }
}

