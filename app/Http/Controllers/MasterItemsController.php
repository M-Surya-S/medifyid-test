<?php

namespace App\Http\Controllers;

use App\Models\KategoriItem;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax;

        $data_search = MasterItem::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');
        if ($hargamin !== null && $hargamin !== '') {
            $data_search = $data_search->where('harga_beli', '>=', $hargamin);
        }
        if ($hargamax !== null && $hargamax !== '') {
            $data_search = $data_search->where('harga_beli', '<=', $hargamax);
        }

        $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();


        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = new MasterItem;
        } else {
            $item = MasterItem::findOrFail($id);
        }

        $data['item'] = $item;
        $data['method'] = $method;
        $data['kategoriItems'] = KategoriItem::orderBy('nama')->get();
        $data['selectedKategoriIds'] = $method == 'edit'
            ? $item->kategoriItems()->pluck('kategori_items.id')->toArray()
            : [];

        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::where('kode', $kode)->first();
        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'harga_beli' => ['required', 'integer', 'min:0'],
            'laba' => ['required', 'integer', 'min:0'],
            'supplier' => ['required', 'string', 'max:255'],
            'jenis' => ['required', 'string', 'max:255'],
            'gambar' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'kategori_ids' => ['nullable', 'array'],
            'kategori_ids.*' => ['integer', 'exists:kategori_items,id'],
            'kategori_baru_nama' => ['nullable', 'required_with:kategori_baru_kode', 'string', 'max:255'],
            'kategori_baru_kode' => ['nullable', 'required_with:kategori_baru_nama', 'string', 'max:255', 'unique:kategori_items,kode'],
        ]);

        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterItem::findOrFail($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $validated['nama'];
        $data_item->harga_beli = $validated['harga_beli'];
        $data_item->laba = $validated['laba'];
        $data_item->kode = $kode;
        $data_item->supplier = $validated['supplier'];
        $data_item->jenis = $validated['jenis'];

        if ($request->hasFile('gambar')) {
            $oldImage = $data_item->gambar;
            $path = $request->file('gambar')->store('master-items', 'public');
            $data_item->gambar = $path;
            $data_item->save();

            if ($oldImage && $oldImage !== $path) {
                Storage::disk('public')->delete($oldImage);
            }
        } else {
            $data_item->save();
        }

        $kategoriIds = $request->input('kategori_ids', []);

        if ($request->filled('kategori_baru_nama') && $request->filled('kategori_baru_kode')) {
            $kategoriBaru = KategoriItem::create([
                'nama' => $validated['kategori_baru_nama'],
                'kode' => $validated['kategori_baru_kode'],
            ]);
            $kategoriIds[] = $kategoriBaru->id;
        }

        $data_item->kategoriItems()->sync(array_unique($kategoriIds));

        return redirect('master-items');
    }

    public function delete($id)
    {
        $item = MasterItem::findOrFail($id);

        if ($item->gambar) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach($data as $item)
        {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100,1000000);
            $item->laba = rand(10,99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi','Bukulapuk','TokoBagas','E Commurz','Blublu'];
        $random = rand(0,4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat','Alkes','Matkes','Umum','ATK'];
        $random = rand(0,4);
        return $array[$random];
    }
}
