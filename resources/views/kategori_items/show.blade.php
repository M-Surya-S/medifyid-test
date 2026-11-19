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
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

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

                        <a class="btn btn-info"
                            href="{{ route('kategori-items.edit', ['kategoriItem' => $kategoriItem->id, 'return_to' => url()->current()]) }}">Edit</a>
                        <a class="btn btn-secondary" href="{{ route('kategori-items.print', $kategoriItem) }}">Download
                            PDF</a>
                        <form method="POST" action="{{ route('kategori-items.destroy', $kategoriItem) }}" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="return_to" value="{{ route('kategori-items.index') }}">
                            <button class="btn btn-danger">Delete</button>
                        </form>

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
                                                    href="{{ url('master-items/view/' . $item->kode) . '?return_to=' . urlencode(url()->current()) }}">View</a>
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
