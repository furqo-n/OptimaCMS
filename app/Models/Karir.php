<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karir extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'jobdesk',
        'kualifikasi',
        'gambar',
        'kontak',
        'benefit',
    ];

    protected $casts = [
        'kualifikasi' => 'array',
        'benefit' => 'array',
    ];
}
