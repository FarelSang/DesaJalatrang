<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $fillable = [
        'judul', 'slug', 'kategori', 'tanggal', 'gambar',
        'ringkasan', 'isi', 'views', 'penulis',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    // URL pakai slug, contoh: /berita/malam-penuh-gengsi-dimulai-...
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getGambarUrlAttribute(): string
    {
        return $this->gambar
            ? asset('images/berita/' . $this->gambar)
            : 'https://placehold.co/400x220?text=Berita+Desa';
    }

    // Cuplikan teks polos (tanpa tag HTML) untuk kartu berita
    public function getExcerptAttribute(): string
    {
        $teks = trim(preg_replace('/\s+/', ' ', strip_tags($this->isi)));

        return Str::limit($teks, 100);
    }

    // Tag otomatis dari kata yang paling sering muncul
    public function getTagsAttribute(): array
    {
        $stop = ['yang', 'dengan', 'untuk', 'dalam', 'dari', 'pada', 'serta', 'oleh', 'akan', 'para',
                 'ini', 'itu', 'juga', 'sebagai', 'adalah', 'dapat', 'kepada', 'tersebut', 'karena',
                 'agar', 'bagi', 'telah', 'sudah', 'saat', 'atau', 'sehingga', 'melalui', 'antar'];

        $teks  = Str::lower(strip_tags($this->judul . ' ' . $this->isi));
        $kata  = preg_split('/[^a-z0-9]+/', $teks, -1, PREG_SPLIT_NO_EMPTY);
        $kata  = array_filter($kata, fn ($k) => strlen($k) >= 4 && ! in_array($k, $stop, true) && ! ctype_digit($k));
        $hitung = array_count_values($kata);
        arsort($hitung);

        $tags = array_slice(array_keys($hitung), 0, 8);
        array_splice($tags, 2, 0, [(string) optional($this->tanggal)->format('Y')]);

        return array_values(array_unique(array_filter($tags)));
    }
}
