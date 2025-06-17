@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Dosen</h1>
    <form method="POST" action="{{ route('dosen_wali.update', $dosen['id_dosen']) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nama Dosen</label>
            <input type="text" name="nama_dosen" class="form-control" value="{{ $dosen['nama_dosen'] }}" required>
        </div>
        <div class="mb-3">
            <label>NIDN</label>
            <input type="text" name="nidn" class="form-control" value="{{ $dosen['nidn'] }}" required>
        </div>
        <div class="mb-3">
            <label>ID User</label>
            <input type="number" name="id_user" class="form-control" value="{{ $dosen['id_user'] }}" required>
        </div>
        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
