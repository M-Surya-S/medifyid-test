<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterItemsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    private int $rowNumber = 0;

    public function collection()
    {
        return MasterItem::with('kategoriItems')
            ->orderBy('id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Nama Item',
            'Nama Supplier',
            'Harga',
            'Laba',
            'Harga Jual',
        ];
    }

    public function map($masterItem): array
    {
        $this->rowNumber++;

        $kategoriNama = $masterItem->kategoriItems->pluck('nama')->implode(', ');
        $hargaJual = (int) round($masterItem->harga_beli + ($masterItem->harga_beli * $masterItem->laba / 100));

        return [
            $this->rowNumber,
            $kategoriNama !== '' ? $kategoriNama : '-',
            $masterItem->nama,
            $masterItem->supplier,
            $masterItem->harga_beli,
            $masterItem->laba,
            $hargaJual,
        ];
    }
}
