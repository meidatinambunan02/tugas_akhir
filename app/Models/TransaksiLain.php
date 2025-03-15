<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiLain extends Model
{
    protected $table = 'transaksi_lain';
    protected $fillable = ['no_trans', 'tgl_trans', 'coa_id', 'user_id', 'total', 'keterangan'];

    public function jurnal()
    {
        return $this->hasMany(Jurnal::class, 'no_jurnal', 'no_trans');
    }


    public function coa()
    {
        return $this->belongsTo(Coa::class);
    }
}
