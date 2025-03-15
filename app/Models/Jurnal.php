<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal';

    protected $fillable = [
        'no_jurnal',
        'tgl_jurnal',
        'coa_id',
        'deskripsi',
        'debit',
        'kredit',
        'user_id',
    ];

    public function coa()
    {
        return $this->belongsTo(Coa::class);
    }
}
    