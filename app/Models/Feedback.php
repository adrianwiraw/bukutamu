<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'buku_tamu_id',
        'rating',
        'feedback',
        'status',
    ];

    public function bukuTamu()
    {
        return $this->belongsTo(BukuTamu::class, 'buku_tamu_id');
    }
}
