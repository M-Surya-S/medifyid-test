<?php

namespace App\Http\Controllers;

use App\Models\KategoriItem;
use Illuminate\Http\Request;

class KategoriItemsController extends Controller
{
    public function index(Request $request)
    {
        $kategoriItems = KategoriItem::query()
            ->when($request->filled('nama'), function ($query) use ($request) {
                $query->where('nama', 'LIKE', '%' . $request->nama . '%');
            })
            ->when($request->filled('kode'), function ($query) use ($request) {
                $query->where('kode', 'LIKE', '%' . $request->kode . '%');
            })
            ->withCount('masterItems')
            ->orderBy('kode')
            ->get();

        return view('kategori_items.index', compact('kategoriItems'));
    }

    public function create(Request $request)
    {
        $returnTo = $request->filled('return_to')
            ? $request->input('return_to')
            : url()->previous();

        return view('kategori_items.create', compact('returnTo'));
    }

    public function edit(Request $request, KategoriItem $kategoriItem)
    {
        $returnTo = $request->filled('return_to')
            ? $request->input('return_to')
            : route('kategori-items.show', $kategoriItem);

        return view('kategori_items.edit', compact('kategoriItem', 'returnTo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
        ]);

        KategoriItem::create([
            'nama' => $validated['nama'],
            'kode' => $this->generateKode(),
        ]);

        $returnTo = $request->input('return_to');
        $appUrl = rtrim(url('/'), '/');

        if ($returnTo && str_starts_with($returnTo, $appUrl . '/')) {
            return redirect($returnTo)
                ->with('success', 'Kategori berhasil ditambahkan.');
        }

        return redirect()->route('kategori-items.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriItem $kategoriItem)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
        ]);

        $kategoriItem->update(['nama' => $validated['nama']]);

        $returnTo = $request->input('return_to');
        $appUrl = rtrim(url('/'), '/');

        if ($returnTo && str_starts_with($returnTo, $appUrl . '/')) {
            return redirect($returnTo)
                ->with('success', 'Kategori berhasil diperbarui.');
        }

        return redirect()->route('kategori-items.show', $kategoriItem)
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Request $request, KategoriItem $kategoriItem)
    {
        $kategoriItem->delete();

        $returnTo = $request->input('return_to');
        $appUrl = rtrim(url('/'), '/');

        if ($returnTo && str_starts_with($returnTo, $appUrl . '/')) {
            return redirect($returnTo)
                ->with('success', 'Kategori berhasil dihapus.');
        }

        return redirect()->route('kategori-items.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    public function show(KategoriItem $kategoriItem)
    {
        $kategoriItem->load(['masterItems' => function ($query) {
            $query->orderBy('kode');
        }]);

        return view('kategori_items.show', compact('kategoriItem'));
    }

    private function generateKode()
    {
        do {
            $next = (KategoriItem::count()) + 1;
            $kode = 'KAT' . str_pad((string) $next, 5, '0', STR_PAD_LEFT);
        } while (KategoriItem::where('kode', $kode)->exists());

        return $kode;
    }
}
