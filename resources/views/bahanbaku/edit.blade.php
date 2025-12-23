@extends('layout')

@section('title', 'Edit Bahan Baku')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit Bahan Baku</h2>

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

            <form action="{{ route('bahanbaku.update', $bahanbaku->kodebaku) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="kodebaku">Kode Baku</label>
                    <input type="text" class="form-control" id="kodebaku" name="kodebaku" value="{{ $bahanbaku->kodebaku }}" readonly>
                </div>
                <div class="form-group">
                    <label for="jenis">Jenis Bahan</label>
                    <input type="text" class="form-control" id="jenis" name="jenis" value="{{ $bahanbaku->jenis }}" required>
                </div>
                <div class="form-group">
                    <label for="satuan">Satuan</label>
                    <input type="text" class="form-control" id="satuan" name="satuan" value="{{ $bahanbaku->satuan }}" required>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" value="{{ $bahanbaku->harga }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('bahanbaku.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection