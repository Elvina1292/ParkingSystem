<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = 'kode_tiket';
    protected $fillable = ['kode_tiket', 'jenis_kendaraan','plat_no','plat_no_1','plat_no_2','plat_no_3','jam_keluar','durasi','tarif'];
}
