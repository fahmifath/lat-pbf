 @extends('layouts.app') 

 @section('content') 
<div class="container">
    <h1>Daftar Dosen Wali</h1>
    <a href="{{ route('dosen_wali.create') }}" class="btn btn-primary mb-3">Tambah Dosen</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>NIDN</th>
                <th>ID User</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dosen_wali as $dosen)
            <tr>
                <td>{{ $dosen['id_dosen'] }}</td>
                <td>{{ $dosen['nama_dosen'] }}</td>
                <td>{{ $dosen['nidn'] }}</td>
                <td>{{ $dosen['id_user'] }}</td>
                <td>
                    <a href="{{ route('dosen_wali.edit', $dosen['id_dosen']) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="{{ route('dosen_wali.destroy', $dosen['id_dosen']) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin ingin hapus?')" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
 @endsection 
