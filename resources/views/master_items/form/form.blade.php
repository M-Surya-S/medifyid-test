<form method="POST" enctype="multipart/form-data">
    @csrf
    @if ($method == 'edit')
        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" class="form-control" name="kode_barang" required readonly value="{{ $item->kode ?? '' }}">
        </div>
    @endif

    <div class="form-group">
        <label>Nama</label>
        <input type="text" class="form-control" name="nama" required value="{{ $item->nama ?? '' }}">
    </div>

    <div class="form-group">
        <label>Kategori Item</label>
        @if ($kategoriItems->isEmpty())
            <p class="text-muted">Belum ada kategori.</p>
        @else
            @foreach ($kategoriItems as $kategori)
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="kategori_ids[]" value="{{ $kategori->id }}"
                        id="kategori-{{ $kategori->id }}"
                        @if (in_array($kategori->id, $selectedKategoriIds)) checked @endif>
                    <label class="form-check-label" for="kategori-{{ $kategori->id }}">
                        {{ $kategori->kode }} - {{ $kategori->nama }}
                    </label>
                </div>
            @endforeach
        @endif
        @error('kategori_ids')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group mt-3">
        <label>Buat Kategori Baru</label>
        <div class="row">
            <div class="col-md-6">
                <input type="text" class="form-control" name="kategori_baru_kode" value="{{ old('kategori_baru_kode') }}" placeholder="Kode kategori">
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" name="kategori_baru_nama" value="{{ old('kategori_baru_nama') }}" placeholder="Nama kategori">
            </div>
        </div>
        @error('kategori_baru_kode')
            <small class="text-danger">{{ $message }}</small>
        @enderror
        @error('kategori_baru_nama')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label>Gambar</label>
        <input type="file" class="form-control" name="gambar" accept="image/jpeg,image/png,image/webp">
        @if ($method == 'edit' && !empty($item->gambar))
            <div class="mt-2">
                <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar {{ $item->nama }}" style="max-width: 200px; max-height: 200px;">
            </div>
        @endif
        @error('gambar')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <label>Harga Beli</label>
        <input type="number" class="form-control" name="harga_beli" required value="{{ $item->harga_beli ?? '' }}">
    </div>

    <div class="form-group">
        <label>Laba (dalam persen)</label>
        <input type="number" class="form-control" name="laba" required value="{{ $item->laba ?? '' }}">
    </div>

    @php $selected = $item->supplier ?? ''; @endphp
    <div class="form-group">
        <label>Supplier</label>
        <select class="form-control" required name="supplier">
            <option @if ($selected == '') selected @endif value="">--Pilih--</option>
            <option @if ($selected == 'Tokopaedi') selected @endif>Tokopaedi</option>
            <option @if ($selected == 'Bukulapuk') selected @endif>Bukulapuk</option>
            <option @if ($selected == 'TokoBagas') selected @endif>TokoBagas</option>
            <option @if ($selected == 'E Commurz') selected @endif>E Commurz</option>
            <option @if ($selected == 'Blublu') selected @endif>Blublu</option>
        </select>
    </div>

    @php $selected = $item->jenis ?? ''; @endphp
    <div class="form-group">
        <label>Jenis</label>
        <select class="form-control" required name="jenis">
            <option @if ($selected == '') selected @endif value="">--Pilih--</option>
            <option @if ($selected == 'Obat') selected @endif>Obat</option>
            <option @if ($selected == 'Alkes') selected @endif>Alkes</option>
            <option @if ($selected == 'Matkes') selected @endif>Matkes</option>
            <option @if ($selected == 'Umum') selected @endif>Umum</option>
            <option @if ($selected == 'ATK') selected @endif>ATK</option>
        </select>
    </div>

    <button class="btn btn-primary mt-3">Submit</button>

</form>
