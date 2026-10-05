<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Komentar extends Model
{
    protected $fillable = ['berita_id', 'nama', 'email', 'no_hp', 'pesan'];

    public function berita(): BelongsTo
    {
        return $this->belongsTo(Berita::class);
    }
}
