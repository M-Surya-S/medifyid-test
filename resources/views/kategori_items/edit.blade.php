@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{ $returnTo }}" class="btn btn-secondary">Kembali</a>
            </div>

            <div class="card">
                <div class="card-header">Edit Kategori Item</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('kategori-items.update', $kategoriItem) }}">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="return_to" value="{{ $returnTo }}">

                        <div class="form-group">
                            <label>Kode Kategori</label>
                            <input type="text" class="form-control" value="{{ $kategoriItem->kode }}" readonly>
                        </div>

                        <div class="form-group mt-2">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control" name="nama" value="{{ old('nama', $kategoriItem->nama) }}" required>
                            @error('nama')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button class="btn btn-primary mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
