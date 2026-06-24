<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Tambahkan import model User di atas jika belum ada
use App\Models\User; 

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kode_barang', 
        'nama_barang', 
        'satuan', 
        'harga'
    ];

    // PERBAIKAN: Ubah fungsi relasi ini menjadi lebih bersih
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}