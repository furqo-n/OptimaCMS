<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'kategori_produk',
        'image',
        'deskripsi_panjang',
        'tools_pengembangan',
        'deskripsi_keunggulan_singkat',
        'advantages',
    ];

    protected $casts = [
        'advantages' => 'array',
    ];
}
