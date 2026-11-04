<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="utf-8">
        <title>Daftar Buku</title>
    </head>
    <body>
        <h1>Daftar Buku</h1>
        <p>Praktikum Pemrograman Web</p>

        <!-- Form Pencarian -->
        <form method="GET" action="{{ url('/buku') }}">
            <p>Cari judul: <input name="cari" value="{{ $cari }}"></p>
            <p><button type="submit">Cari</button></p>
        </form>

        <!-- Tabel Daftar Buku -->
        <table border="1" cellpadding="5" cellspacing="0">
            <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Detail</th>
            </tr>
            @foreach ($buku as $item)
                <tr>
                    <td>{{ $item['kode'] }}</td>
                    <td>{{ $item['judul'] }}</td>
                    <td><a href="{{ url('/buku/'.$item['kode'])
                    }}">Lihat</a></td>
                </tr>
            @endforeach
        </table>

        <!-- Teks jika pencarian tidak menemukan hasil -->
        @if (count($buku) === 0)
            <p>Data buku tidak ditemukan.</p>
        @endif
    </body>
    </html>