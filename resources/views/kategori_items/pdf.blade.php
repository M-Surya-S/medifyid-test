<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Kategori {{ $kategoriItem->kode }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
        }

        .header {
            margin-bottom: 14px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }

        .meta-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .meta-key {
            width: 130px;
            font-weight: bold;
        }

        .items-title {
            font-size: 14px;
            font-weight: bold;
            margin: 8px 0;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
        }

        .items-table th,
        .items-table td {
            border: 1px solid #444;
            padding: 6px;
            text-align: left;
        }

        .items-table th {
            background: #efefef;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 16px;
            font-size: 11px;
            color: #555;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Detail Kategori Item</div>

        <table class="meta-table">
            <tr>
                <td class="meta-key">Nama Kategori</td>
                <td>: {{ $kategoriItem->nama }}</td>
            </tr>
            <tr>
                <td class="meta-key">Kode Kategori</td>
                <td>: {{ $kategoriItem->kode }}</td>
            </tr>
        </table>
    </div>

    <div class="items-title">Daftar Item Pada Kategori</div>
    <table class="items-table">
        <thead>
            <tr>
                <th style="width: 40px;">No</th>
                <th>Kode Item</th>
                <th>Nama Item</th>
                <th>Jenis</th>
                <th>Supplier</th>
                <th style="width: 110px;">Harga Beli</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategoriItem->masterItems as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->kode }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->jenis }}</td>
                    <td>{{ $item->supplier }}</td>
                    <td>{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada item pada kategori ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ $printedAt->format('d-m-Y H:i:s') }}
    </div>
</body>

</html>
