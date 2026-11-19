@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-group mb-2">
                    <a href="{{ route('kategori-items.index') }}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
                </div>

                <div class="card">
                    <div class="card-header">Kategori Item</div>
                    <div class="card-body">
                        <table class="table table-borderless mb-4">
                            <tr>
                                <th style="width: 180px">Kode Kategori</th>
                                <td>{{ $kategoriItem->kode }}</td>
                            </tr>
                            <tr>
                                <th>Nama Kategori</th>
                                <td>{{ $kategoriItem->nama }}</td>
                            </tr>
                        </table>

                        <h5>Daftar Master Item</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Jenis</th>
                                        <th>Harga Beli</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kategoriItem->masterItems as $item)
                                        <tr>
                                            <td>{{ $item->kode }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->jenis }}</td>
                                            <td>{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                            <td>
                                                <a class="btn btn-sm btn-primary"
                                                    href="{{ url('master-items/view/' . $item->kode) }}">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada master item pada
                                                kategori ini.</td>
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
