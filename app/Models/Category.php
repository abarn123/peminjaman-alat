<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tool;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // Semua field mass assignable kecuali primary key
    protected $guarded = [];

    // Relasi satu kategori memiliki banyak alat(one-to-many)
    public function tools()
    {
        return $this->hasMany(Tool::class);
    }
}
