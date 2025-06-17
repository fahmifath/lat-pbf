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
