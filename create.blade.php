@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Dosen</h1>
    <form method="POST" action="{{ route('dosen_wali.store') }}">
        @csrf
        <div class="mb-3">
            <label>Nama Dosen</label>
            <input type="text" name="nama_dosen" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>NIDN</label>
            <input type="text" name="nidn" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>ID User</label>
            <input type="number" name="id_user" class="form-control" required>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
