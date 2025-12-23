@extends('layout')

@section('title', 'Edit Supplier')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit Data Supplier</h2>

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

            <form action="{{ route('supplier.update', $supplier->idsupplier) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="idsupplier">ID Supplier</label>
                    <input type="text" class="form-control" id="idsupplier" name="idsupplier" value="{{ $supplier->idsupplier }}" readonly>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Supplier</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $supplier->nama }}" required>
                </div>
                <div class="form-group">
                    <label for="telp">No. Telepon</label>
                    <input type="number" class="form-control" id="telp" name="telp" value="{{ $supplier->telp }}" required>
                </div>
                <div class="form-group">
                    <label for="pic">PIC</label>
                    <input type="text" class="form-control" id="pic" name="pic" value="{{ $supplier->pic }}" required>
                </div>
                <div class="form-group">
                    <label for="telppic">No. Telepon PIC</label>
                    <input type="number" class="form-control" id="telppic" name="telppic" value="{{ $supplier->telppic }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection