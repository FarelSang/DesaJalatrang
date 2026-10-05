<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $beritas = Berita::query()
            ->when($request->kata_kunci, function ($q, $kata) {
                $q->where('judul', 'like', "%{$kata}%");
            })
            ->when($request->kategori, function ($q, $kategori) {
                $q->where('kategori', $kategori);
            })
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('berita.index', compact('beritas'));
    }

    public function create()
    {
        return view('berita.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'    => 'required|max:255',
            'kategori' => 'required',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'isi'      => 'required|min:10',
        ]);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');

            $namaGambar = time() . '_' . $gambar->getClientOriginalName();

            $gambar->move(
                public_path('images/berita'),
                $namaGambar
            );

            $data['gambar'] = $namaGambar;
        }

        $data['slug'] = Str::slug($data['judul']);
        $data['tanggal'] = now()->toDateString();
        $data['ringkasan'] = Str::limit(strip_tags($data['isi']), 150);
        $data['views'] = 0;

        Berita::create($data);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    public function show(Request $request, Berita $berita)
    {
        // Jangan tambah views saat halaman dibuka lagi setelah kirim komentar
        if (! session('komentar_ok') && ! $request->session()->has('errors')) {
            $berita->increment('views');
        }

        $komentars = $berita->komentars()->latest()->get();
        $soal = KomentarController::buatSoal();

        $terkait = Berita::where('id', '!=', $berita->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->take(5)
            ->get();

        return view('berita.show', compact('berita', 'terkait', 'komentars', 'soal'));
    }

    public function edit(Berita $berita)
    {
        return view('berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'judul'    => 'required|max:255',
            'kategori' => 'required',
            'gambar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'isi'      => 'required|min:10',
        ]);

        if ($request->hasFile('gambar')) {

            // Hapus gambar lama
            if ($berita->gambar) {
                $gambarLama = public_path('images/berita/' . $berita->gambar);

                if (file_exists($gambarLama)) {
                    unlink($gambarLama);
                }
            }

            // Simpan gambar baru
            $gambar = $request->file('gambar');
            $namaGambar = time() . '_' . $gambar->getClientOriginalName();
            $gambar->move(public_path('images/berita'), $namaGambar);

            $data['gambar'] = $namaGambar;
        }

        $data['slug'] = Str::slug($data['judul']);
        $data['ringkasan'] = Str::limit(strip_tags($data['isi']), 150);

        $berita->update($data);

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil diperbarui!');
    }

    public function destroy(Berita $berita)
    {
        if ($berita->gambar) {
            $gambar = public_path('images/berita/' . $berita->gambar);

            if (file_exists($gambar)) {
                unlink($gambar);
            }
        }

        $berita->delete();

        return redirect()->route('berita.index')
            ->with('success', 'Berita berhasil dihapus!');
    }
}
