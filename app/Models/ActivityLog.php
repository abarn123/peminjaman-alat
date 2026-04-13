<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    // Semua field mass assignable kecuali primary key
    protected $guarded = [];

    // Relasi ke user 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper statis untuk menyimpan log aktivitas otomatis
    public static function record($action, $desc = null)
    {
        self::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $desc
        ]);
    }
}
