@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-group mb-2">
                    <a href="{{ route('kategori-items.create') }}" class="btn btn-secondary">+ Kategori Item Baru</a>
                </div>

                <div class="card">
                    <div class="card-header">Daftar Kategori Item</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div id="filter-container">
                            <h4>Filter</h4>
                            <form method="GET" action="{{ route('kategori-items.index') }}" class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Kode</label>
                                        <input type="text" class="form-control" name="kode"
                                            value="{{ request('kode') }}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" class="form-control" name="nama"
                                            value="{{ request('nama') }}">
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <button class="btn btn-primary btn-get-data">Filter</button>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table id="table" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Jumlah Item</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kategoriItems as $kategori)
                                        <tr>
                                            <td>{{ $kategori->kode }}</td>
                                            <td>
                                                <form method="POST"
                                                    action="{{ route('kategori-items.update', $kategori) }}" class="d-flex">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" class="form-control form-control-sm me-2"
                                                        name="nama" value="{{ $kategori->nama }}" required>
                                                    <button class="btn btn-sm btn-warning">Simpan</button>
                                                </form>
                                            </td>
                                            <td>{{ $kategori->master_items_count }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('kategori-items.show', $kategori) }}">View</a>
                                                <form method="POST"
                                                    action="{{ route('kategori-items.destroy', $kategori) }}"
                                                    class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Belum ada kategori.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
