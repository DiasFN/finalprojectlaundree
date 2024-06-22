<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $tables = "laundry";
    protected $fillable = [
        'name_customer',
        'no_hp',
        'alamat',
        'jenisLayanan',
        'berat',
        'tgl_terima',
        'tgl_selesai',
        'catatan'
    ];

    protected $hidden = [
        'no_hp',
        'alamat'
    ];
}