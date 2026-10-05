<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function store(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'nama'    => 'required|max:100',
            'email'   => 'required|email|max:255',
            'no_hp'   => ['required', 'regex:/^[0-9+\-\s]{8,20}$/'],
            'pesan'   => 'required|max:300',
            'captcha' => 'required',
        ], [
            'no_hp.regex' => 'Nomor HP tidak valid.',
        ]);

        // Cek captcha dari session
        if ((int) $data['captcha'] !== (int) session('captcha_jawab')) {
            return back()
                ->withErrors(['captcha' => 'Jawaban captcha salah.'])
                ->withInput()
                ->withFragment('komentar');
        }

        $berita->komentars()->create([
            'nama'  => strip_tags($data['nama']),
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'pesan' => strip_tags($data['pesan']),
        ]);

        session()->forget('captcha_jawab');

        return redirect()
            ->to(route('berita.show', $berita) . '#komentar')
            ->with('komentar_ok', 'Komentar berhasil dikirim. Terima kasih!');
    }

    // Soal captcha baru (dipanggil tombol refresh)
    public function captcha()
    {
        return response()->json(['soal' => $this->buatSoal()]);
    }

    public static function buatSoal(): string
    {
        $a = random_int(1, 9);
        $b = random_int(1, 10);
        session(['captcha_jawab' => $a + $b]);

        return "$a + $b = ?";
    }
}
