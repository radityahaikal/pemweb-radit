@extends('layout')

@section('title', 'Edit Pegawai')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit Pegawai</h2>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pegawai.update', $pegawai->idpegawai) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="idpegawai">Id Pegawai</label>
                    <input type="text" class="form-control" id="idpegawai" name="idpegawai" value="{{ $pegawai->idpegawai }}" readonly>
                </div>
                <div class="form-group">
                    <label for="namapegawai">Nama Pegawai</label>
                    <input type="text" class="form-control" id="namapegawai" name="namapegawai" value="{{ $pegawai->namapegawai }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection