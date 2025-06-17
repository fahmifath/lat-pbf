<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MahasiswaController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8080/mahasiswa');
        $mhs = $response->json();
        return view('mahasiswa.index', compact('mhs'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'npm' => 'required|integer',
            'id_user' => 'required|integer',
            'id_dosen' => 'required|integer',
            'id_kajur' => 'required|integer',
            'nama_mahasiswa' => 'required|string|max:50',
            'tempat_tanggal_lahir' => 'required|string|max:50',
            'jenis_kelamin' => 'required|string|max:10',
            'alamat' => 'required|string|max:100',
            'agama' => 'required|string|max:20',
            'angkatan' => 'required|integer',
            'program_studi' => 'required|string|max:20',
            'semester' => 'required|integer',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email',

        ]);

        $response = Http::asJson()->post('http://localhost:8080/mahasiswa', [
            'npm' => $request->npm,
            'id_user' => $request->id_user,
            'id_dosen' => $request->id_dosen,
            'id_kajur' => $request->id_kajur,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'tempat_tanggal_lahir' => $request->tempat_tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'agama' => $request->agama,
            'angkatan' => $request->angkatan,
            'program_studi' => $request->program_studi,
            'semester' => $request->semester,
            'no_hp' => $request->no_hp,
            'email' => $request->email
        ]);

        if ($response->successful()) {
            return redirect()->route('mahasiswa.index')->with('success', 'Berhasil menambahkan mahasiswa.');
        }

        return back()->withErrors(['error' => 'Gagal menambahkan data'])->withInput();
    }

    public function edit($npm)
    {
        $response = Http::get("http://localhost:8080/mahasiswa/$npm");

        if ($response->successful()) {
            $mahasiswa = $response->json()[0];
            return view('mahasiswa.edit', compact('mahasiswa'));
        }

        return back()->with('error', 'Data tidak ditemukan.');
    }

    public function update(Request $request, $npm)
    {
        $request->validate([
            'npm' => 'required|integer',
            'id_user' => 'required|integer',
            'id_dosen' => 'required|integer',
            'id_kajur' => 'required|integer',
            'nama_mahasiswa' => 'required|string|max:50',
            'tempat_tanggal_lahir' => 'required|string|max:50',
            'jenis_kelamin' => 'required|string|max:10',
            'alamat' => 'required|string|max:100',
            'agama' => 'required|string|max:20',
            'angkatan' => 'required|integer',
            'program_studi' => 'required|string|max:20',
            'semester' => 'required|integer',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|email',
        ]);

        $response = Http::put("http://localhost:8080/mahasiswa/$npm", $request->all());

        if ($response->successful()) {
            return redirect()->route('mahasiswa.index')->with('success', 'Berhasil mengupdate data.');
        }

        return back()->withErrors(['error' => 'Gagal mengupdate data'])->withInput();
    }

    public function destroy($npm)
    {
        $response = Http::delete("http://localhost:8080/mahasiswa/$npm");

        if ($response->successful()) {
            return redirect()->route('mahasiswa.index')->with('success', 'Berhasil menghapus data.');
        }

        return back()->with('error', 'Gagal menghapus data.');
    }
}


1. 📦 Install Laravel DomPDF
Jalankan perintah berikut di terminal:

bash
Copy
Edit
composer require barryvdh/laravel-dompdf
2. 📄 Buat Route Export
Tambahkan route di routes/web.php:

php
Copy
Edit
use App\Http\Controllers\PengajuanController;

Route::get('/pengajuan/export-pdf', [PengajuanController::class, 'exportPdf'])->name('pengajuan.exportPdf');
3. 🧠 Tambahkan Fungsi di Controller
Contoh di PengajuanController.php:

php
Copy
Edit
use Barryvdh\DomPDF\Facade\Pdf; // tambahkan ini di atas

public function exportPdf()
{
    $data = Pengajuan::with(['sasaranKegiatan', 'iku', 'ro', 'komponen', 'subKomponen', 'akun'])->get();

    $pdf = Pdf::loadView('pengajuan.pdf', compact('data'));

    return $pdf->download('laporan-pengajuan.pdf');
}
4. 🧾 Buat View PDF
Buat file view: resources/views/pengajuan/pdf.blade.php

Contoh isi file:

blade
Copy
Edit
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengajuan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Data Pengajuan</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Pengajuan</th>
                <th>Unit</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->pengajuan }}</td>
                <td>{{ $item->unit_pengaju }}</td>
                <td>Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                <td>{{ ucfirst($item->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
5. (Opsional) 📎 Tambahkan Tombol Export di Blade
Misalnya di pengajuan/index.blade.php:

blade
Copy
Edit
<a href="{{ route('pengajuan.exportPdf') }}" class="btn btn-danger mb-3">Export PDF</a>
✅ Hasil
Ketika kamu buka http://127.0.0.1:8000/pengajuan/export-pdf, PDF akan otomatis di-download.

Kamu juga bisa pakai $pdf->stream() untuk menampilkan langsung di browser:

php
Copy
Edit
return $pdf->stream('laporan-pengajuan.pdf');
Kalau kamu ingin fitur tambahan seperti export per unit saja, atau berdasarkan filter tertentu, tinggal tambahkan parameter di URL dan query datanya sebelum di-passing ke view PDF. Mau saya bantu juga buatkan versi dengan filter?
