<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class Loan extends Model
{
protected $guarded = [];
public function user() { return $this->belongsTo(User::class); }
public function tool() { return $this->belongsTo(Tool::class); }
public function petugas() { return $this->belongsTo(User::class, 'petugas_id'); }

public function isLate()
{
        return $this->tanggal_kembali_aktual
            && Carbon::parse($this->tanggal_kembali_aktual)->gt(Carbon::parse($this->tanggal_kembali_rencana));
    }

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
