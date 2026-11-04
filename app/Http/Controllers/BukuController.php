<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use Illuminate\View\View;

class BukuController extends Controller
{
    // menampilkan daftar buku dan filter pencarian
    public function index(Request $request): View
    {
        $cari = trim((string) $request->query('cari', ''));

        // filter array buku berdasarkan kata kunci pencarian judul
        $buku = array_values(array_filter(Buku::contoh(),
        fn ($item) => $cari === '' || stripos($item['judul'],
        $cari) !== false
        ));

        return view('buku.index', compact('buku', 'cari'));
    }
        // menampilkan detail buku berdasarkan kode, atau abort 404 jika tidak ada
        public function show(string $kode): View
        {
            foreach (Buku::contoh() as $item) {
                if ($item['kode'] === $kode) {
                    return view('buku.show', ['buku' => $item]);
                }
            }

            abort(404);
        }
    
}
