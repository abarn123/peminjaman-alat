<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    // Semua field mass assignable kecuali primary key
    protected $guarded = [];

    // Relasi alat ke kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi alat ke banyak pinjaman
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}

